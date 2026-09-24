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
            'skills' => $cv->extracted_skills ?? [],
            'qualifications' => $cv->extracted_qualifications ?? [],
        ];

        if (empty($original['skills']) && empty($original['qualifications'])) {
            abort(422, 'This CV has no extracted data');
        }

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.5-flash');

        if (empty($apiKey)) {
            abort(503, 'Gemini API key is not configured');
        }

        try {
            $response = Http::timeout(90)
                ->retry(
                    2,
                    1500,
                    fn ($exception) =>
                        in_array(
                            optional($exception->response ?? null)->status(),
                            [429, 500, 502, 503, 504],
                            true
                        ),
                    throw: false
                )
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $this->prompt(
                                            $cv,
                                            $original,
                                            $scholarship
                                        ),
                                    ],
                                ],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.3,
                            'responseMimeType' => 'application/json',
                        ],
                    ]
                );
        } catch (\Throwable $e) {
            report($e);

            abort(
                503,
                'AI service connection failed'
            );
        }

        if ($response->failed()) {
            logger()->warning('CV Tailor Gemini request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            abort(
                502,
                'AI service unavailable: ' . $response->status()
            );
        }

        $text = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text',
            ''
        );

        $parsed = json_decode($text, true);

        if (
            !is_array($parsed) ||
            !isset($parsed['suggestions']) ||
            !is_array($parsed['suggestions'])
        ) {
            logger()->warning('CV Tailor returned invalid JSON', [
                'response_text' => $text,
            ]);

            abort(502, 'Invalid AI response');
        }

        return [
            'suggestions' => $this->verify(
                $original,
                $parsed['suggestions']
            ),
        ];
    }

    private function prompt(
        Cv $cv,
        array $original,
        Scholarship $scholarship
    ): string {
        $cvJson = json_encode(
            [
                'skills' => $original['skills'],
                'qualifications' => $original['qualifications'],
                'education' => $cv->extracted_education ?? [],
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        return <<<PROMPT
You are a CV editor.

Tailor the CV below for the scholarship described.

STRICT RULES:

- Only REORDER and lightly REWORD existing items to highlight what matches the scholarship.
- NEVER add skills, certificates, degrees, projects, numbers, dates, achievements, employers, or institutions that are not in the original CV.
- Editable sections are ONLY "skills" and "qualifications".
- "education" is context only and must not be edited.
- "skills" and "qualifications" must remain arrays of strings.
- Keep the same language as the original items.
- Skip a section if it needs no change.
- Do not invent information.

SCHOLARSHIP:
Title: {$scholarship->title}
Provider: {$scholarship->provider_name}
Field: {$scholarship->field_of_study}
Degree Level: {$scholarship->degree_level}
Country: {$scholarship->country}
Description: {$scholarship->description}

CV:
{$cvJson}

Return ONLY valid JSON using exactly this structure:

{
  "suggestions": [
    {
      "section": "skills",
      "suggested": ["..."],
      "reason": "one short sentence"
    }
  ]
}
PROMPT;
    }

    private function verify(
        array $original,
        array $suggestions
    ): array {
        $out = [];

        foreach ($suggestions as $suggestion) {
            $section = $suggestion['section'] ?? null;

            if (
                !in_array(
                    $section,
                    ['skills', 'qualifications'],
                    true
                ) ||
                !isset($suggestion['suggested']) ||
                !is_array($suggestion['suggested'])
            ) {
                continue;
            }

            $originalItems = array_values(
                array_map(
                    'strval',
                    $original[$section]
                )
            );

            $suggestedItems = array_values(
                array_map(
                    'strval',
                    $suggestion['suggested']
                )
            );

            /*
             * Skills are strictly limited to skills that
             * already exist in the original CV.
             */
            if ($section === 'skills') {
                $originalLookup = [];

                foreach ($originalItems as $item) {
                    $originalLookup[mb_strtolower($item)] = $item;
                }

                $verified = [];

                foreach ($suggestedItems as $item) {
                    $key = mb_strtolower($item);

                    if (isset($originalLookup[$key])) {
                        $verified[] = $originalLookup[$key];
                    }
                }

                $suggestedItems = array_values(
                    array_unique($verified)
                );
            }

            if (empty($suggestedItems)) {
                continue;
            }

            if ($suggestedItems === $originalItems) {
                continue;
            }

            $newNumbers = array_values(
                array_diff(
                    $this->numbers($suggestedItems),
                    $this->numbers($originalItems)
                )
            );

            $out[] = [
                'section' => $section,
                'original' => $originalItems,
                'suggested' => $suggestedItems,
                'reason' => (string) ($suggestion['reason'] ?? ''),
                'flagged' => !empty($newNumbers),
                'new_numbers' => $newNumbers,
            ];
        }

        return $out;
    }

    private function numbers($value): array
    {
        $json = json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
        );

        preg_match_all(
            '/\d+(?:[.,]\d+)?/u',
            $json ?: '',
            $matches
        );

        return array_values(
            array_unique($matches[0] ?? [])
        );
    }
}
