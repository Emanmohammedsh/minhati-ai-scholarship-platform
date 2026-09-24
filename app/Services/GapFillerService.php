<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GapFillerService
{
    /**
     * Generate an AI learning plan for a missing job requirement.
     */
    public function generatePlan(
        string $jobTitle,
        string $requirementType,
        string $missingRequirement,
        array $currentSkills = []
    ): array {
        $apiKey = config('services.gemini.key');
        $model = config(
            'services.gemini.model',
            'gemini-3.5-flash'
        );

        if (! $apiKey) {
            return $this->fallbackPlan(
                $missingRequirement
            );
        }

        $skills = empty($currentSkills)
            ? 'Not provided'
            : implode(', ', $currentSkills);

        $prompt = <<<PROMPT
You are Jisr AI, a career readiness assistant.

Create a short learning plan for a job seeker.

Job title:
{$jobTitle}

Missing requirement type:
{$requirementType}

Missing requirement:
{$missingRequirement}

Current verified CV skills:
{$skills}

Rules:
- Do not invent skills or experience.
- Focus only on the missing requirement.
- Keep the plan practical and beginner-friendly.
- Do not invent course names, URLs, certificates,
  employers, or institutions.
- Do not claim that completing the plan guarantees
  employment.
- Return JSON only.

Return exactly this JSON structure:

{
  "why_it_matters": "short explanation",
  "learning_goal": "one clear goal",
  "steps": [
    "step 1",
    "step 2",
    "step 3"
  ],
  "practice_task": "one practical task",
  "search_keywords": [
    "keyword 1",
    "keyword 2"
  ]
}
PROMPT;

        try {
            $response = Http::timeout(30)
                ->post(
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
                            'responseMimeType'
                                => 'application/json',
                        ],
                    ]
                );

            if (! $response->successful()) {
                Log::warning(
                    'Gap Filler Gemini request failed.',
                    [
                        'status'
                            => $response->status(),
                    ]
                );

                return $this->fallbackPlan(
                    $missingRequirement
                );
            }

            $text = data_get(
                $response->json(),
                'candidates.0.content.parts.0.text'
            );

            if (! $text) {
                return $this->fallbackPlan(
                    $missingRequirement
                );
            }

            $plan = json_decode(
                $text,
                true
            );

            if (
                ! is_array($plan)
                || empty($plan['why_it_matters'])
                || empty($plan['learning_goal'])
                || empty($plan['steps'])
            ) {
                return $this->fallbackPlan(
                    $missingRequirement
                );
            }

            return [
                'source' => 'ai',
                'missing_requirement'
                    => $missingRequirement,

                'why_it_matters'
                    => $plan['why_it_matters'],

                'learning_goal'
                    => $plan['learning_goal'],

                'steps' => array_slice(
                    $plan['steps'],
                    0,
                    5
                ),

                'practice_task'
                    => $plan['practice_task']
                        ?? null,

                'search_keywords'
                    => array_slice(
                        $plan['search_keywords']
                            ?? [],
                        0,
                        5
                    ),
            ];
        } catch (\Throwable $e) {
            Log::warning(
                'Gap Filler AI unavailable.',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return $this->fallbackPlan(
                $missingRequirement
            );
        }
    }

    /**
     * Safe response when Gemini is unavailable.
     */
    private function fallbackPlan(
        string $missingRequirement
    ): array {
        return [
            'source' => 'fallback',

            'missing_requirement'
                => $missingRequirement,

            'why_it_matters'
                => "This requirement is part of the job criteria.",

            'learning_goal'
                => "Build practical knowledge in {$missingRequirement}.",

            'steps' => [
                "Learn the fundamentals of {$missingRequirement}.",
                "Practice {$missingRequirement} with a small exercise.",
                "Build a small project or example using {$missingRequirement}.",
            ],

            'practice_task'
                => "Create a small practical example that demonstrates {$missingRequirement}.",

            'search_keywords' => [
                "{$missingRequirement} beginner course",
                "{$missingRequirement} practical tutorial",
            ],
        ];
    }
}

