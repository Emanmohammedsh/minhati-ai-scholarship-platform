<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CourseRecommendationService
{
    /**
     * Suggest a free course covering a specific missing skill/criterion.
     * Cached per skill name so we don't re-call Gemini
     * for the same gap repeatedly.
     */
    public function suggestForSkill(string $skillName): ?array
    {
        $cacheKey =
            'course_suggestion:' .
            strtolower(trim($skillName));

        return Cache::remember(
            $cacheKey,
            now()->addDays(30),
            function () use ($skillName) {
                return $this->askGemini($skillName);
            }
        );
    }

    /**
     * Ask Gemini for one free or free-to-audit
     * learning resource for the missing skill.
     */
    private function askGemini(string $skillName): ?array
    {
        $apiKey = config('services.gemini.key');

        $model = config(
            'services.gemini.model',
            'gemini-3.5-flash'
        );

        if (!$apiKey) {
            Log::warning(
                'Gemini course suggestion skipped: API key is missing.'
            );

            return null;
        }

        $prompt = <<<PROMPT
A student is missing this skill or qualification: "{$skillName}".

Suggest ONE real, well-known, free or free-to-audit online course
that teaches this skill.

Use a real learning platform such as:
Coursera, edX, freeCodeCamp, Khan Academy, Google,
or another established learning platform.

Respond ONLY with valid JSON.
Do not include markdown or additional explanation.

Use exactly this structure:

{
  "course_title": "string",
  "platform": "string",
  "estimated_duration": "string",
  "url": "string"
}

Rules:
- Do not invent a course.
- Do not invent a platform.
- Do not invent a URL.
- Prefer a free course or a course that can be audited for free.
- If you are not confident that a specific course URL is real,
  return the official platform search or homepage URL instead.
- estimated_duration may be something like
  "4 hours", "2 weeks", or "Self-paced".
PROMPT;

        try {
            $response = Http::timeout(20)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt,
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

            if (!$response->successful()) {
                Log::error(
                    'Gemini course suggestion failed',
                    [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]
                );

                return null;
            }

            $text = $response->json(
                'candidates.0.content.parts.0.text'
            );

            if (!$text) {
                Log::error(
                    'Gemini course suggestion returned no text.'
                );

                return null;
            }

            $decoded = json_decode(
                $text,
                true
            );

            if (
                !is_array($decoded) ||
                empty($decoded['course_title'])
            ) {
                Log::error(
                    'Gemini course suggestion: could not parse JSON',
                    [
                        'raw' => $text,
                    ]
                );

                return null;
            }

            return [
                'course_title' =>
                    $decoded['course_title'] ?? null,

                'platform' =>
                    $decoded['platform'] ?? null,

                'estimated_duration' =>
                    $decoded['estimated_duration'] ?? null,

                'url' =>
                    $decoded['url'] ?? null,
            ];
        } catch (\Throwable $e) {
            Log::error(
                'Gemini course suggestion exception',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return null;
        }
    }
}

