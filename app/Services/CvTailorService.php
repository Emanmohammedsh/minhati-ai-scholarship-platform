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
            'skills' => array_values($cv->extracted_skills ?? []),
            'qualifications' => array_values($cv->extracted_qualifications ?? []),
        ];

        if (empty($original['skills']) && empty($original['qualifications'])) {
            abort(422, 'This CV has no extracted data');
        }

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.5-flash');

        if (empty($apiKey)) {
            return $this->fallback($original, $scholarship);
        }

        try {
            $response = Http::connectTimeout(5)
                            ->timeout(15)
                            ->retry(
                                1,
                                500,
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

            logger()->warning('CV Tailor Gemini connection failed; using fallback.', [
                'message' => $e->getMessage(),
            ]);

            return $this->fallback($original, $scholarship);
        }

        if ($response->failed()) {
            logger()->warning('CV Tailor Gemini request failed; using fallback.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->fallback($original, $scholarship);
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
            logger()->warning('CV Tailor returned invalid JSON; using fallback.', [
                'response_text' => $text,
            ]);

            return $this->fallback($original, $scholarship);
        }

        $suggestions = $this->verify(
            $original,
            $parsed['suggestions']
        );

        if (empty($suggestions)) {
            return $this->fallback($original, $scholarship);
        }

        return [
            'suggestions' => $suggestions,
            'source' => 'ai',
            'fallback' => false,
        ];
    }

    private function fallback(
        array $original,
        Scholarship $scholarship
    ): array {
        $suggestions = [];

        /*
         * Safe fallback:
         * It never creates new CV information.
         * It only keeps the user's existing extracted data.
         */

        if (!empty($original['skills'])) {
            $suggestions[] = [
                'section' => 'skills',
                'original' => array_values($original['skills']),
                'suggested' => array_values($original['skills']),
                'reason' => 'AI tailoring is temporarily unavailable. Your existing skills were kept unchanged.',
                'flagged' => false,
                'new_numbers' => [],
            ];
        }

        if (!empty($original['qualifications'])) {
            $suggestions[] = [
                'section' => 'qualifications',
                'original' => array_values($original['qualifications']),
                'suggested' => array_values($original['qualifications']),
                'reason' => 'AI tailoring is temporarily unavailable. Your existing qualifications were kept unchanged.',
                'flagged' => false,
                'new_numbers' => [],
            ];
        }

        return [
            'suggestions' => $suggestions,
            'source' => 'fallback',
            'fallback' => true,
            'message' => 'AI tailoring is temporarily unavailable. Existing CV information is shown without adding or inventing any data.',
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
