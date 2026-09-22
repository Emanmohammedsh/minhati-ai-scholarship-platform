<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Http;

class CvTailorService
{
    public function tailor(Cv $cv, Scholarship $scholarship): array
    {
        $original = [
            'skills'         => $cv->extracted_skills ?? [],
            'qualifications' => $cv->extracted_qualifications ?? [],
        ];

        if (empty($original['skills']) && empty($original['qualifications'])) {
            abort(422, 'This CV has no extracted data');
        }

        $response = Http::timeout(60)
    ->retry(3, 2000, fn ($e) => in_array(optional($e->response ?? null)->status(), [429, 500, 503]), throw: false)
    ->withHeaders(['x-goog-api-key' => config('services.gemini.key')])
    ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/'
                . config('services.gemini.model') . ':generateContent',
                [
                    'contents' => [['parts' => [['text' => $this->prompt($cv, $original, $scholarship)]]]],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'responseMimeType' => 'application/json',
                    ],
                ]
            );

        if ($response->failed()) {
            abort(502, 'AI service unavailable: ' . $response->status());
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text', '');
        $parsed = json_decode($text, true);

        if (!is_array($parsed) || !isset($parsed['suggestions']) || !is_array($parsed['suggestions'])) {
            abort(502, 'Invalid AI response');
        }

        return ['suggestions' => $this->verify($original, $parsed['suggestions'])];
    }

    private function prompt(Cv $cv, array $original, Scholarship $s): string
    {
        $cvJson = json_encode([
            'skills'         => $original['skills'],
            'qualifications' => $original['qualifications'],
            'education'      => $cv->extracted_education ?? [],
        ], JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
You are a CV editor. Tailor the CV below for the scholarship described.

STRICT RULES:
- Only REORDER and lightly REWORD existing items to highlight what matches the scholarship.
- NEVER add skills, certificates, degrees, projects, numbers, dates, or achievements that are not in the original CV.
- Editable sections are ONLY "skills" and "qualifications". "education" is context only, do not edit it.
- "skills" and "qualifications" must stay arrays of strings.
- Keep the same language as the original items.
- Skip a section if it needs no change.

SCHOLARSHIP: {$s->title}
PROVIDER: {$s->provider_name}
FIELD: {$s->field_of_study}
DEGREE LEVEL: {$s->degree_level}
COUNTRY: {$s->country}
DESCRIPTION: {$s->description}

CV (JSON):
{$cvJson}

Return ONLY this JSON:
{"suggestions":[{"section":"skills or qualifications","suggested":["..."],"reason":"one short sentence"}]}
PROMPT;
    }

    // الكود هو الحَكَم، مش الـ AI
    private function verify(array $original, array $suggestions): array
    {
        $out = [];

        foreach ($suggestions as $sug) {
            $section = $sug['section'] ?? null;

            if (!in_array($section, ['skills', 'qualifications'], true)
                || !isset($sug['suggested'])
                || !is_array($sug['suggested'])) {
                continue;
            }

            $orig = $original[$section];
            $suggested = array_values(array_map('strval', $sug['suggested']));

            // المهارات: بس اللي موجود أصلاً بالـ CV
            if ($section === 'skills') {
                $lower = array_map('mb_strtolower', array_map('strval', $orig));
                $suggested = array_values(array_unique(array_filter(
                    $suggested,
                    fn ($x) => in_array(mb_strtolower($x), $lower, true)
                )));
            }

            if ($suggested === array_map('strval', $orig)) {
                continue; // ما تغيّر شي
            }

            // أي رقم جديد مش موجود بالأصلي = علامة تحذير
            $newNums = array_values(array_diff($this->numbers($suggested), $this->numbers($orig)));

            $out[] = [
                'section'     => $section,
                'original'    => $orig,       // من قاعدة البيانات مش من الـ AI
                'suggested'   => $suggested,
                'reason'      => $sug['reason'] ?? '',
                'flagged'     => !empty($newNums),
                'new_numbers' => $newNums,
            ];
        }

        return $out;
    }

    private function numbers($value): array
    {
        preg_match_all('/\d+(?:[.,]\d+)?/u', json_encode($value, JSON_UNESCAPED_UNICODE), $m);
        return array_values(array_unique($m[0]));
    }
}