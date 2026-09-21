<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CourseRecommendationService
{
    /**
     * Suggest a free course covering a specific missing skill/criterion.
     * Cached per skill name so we don't re-call Gemini for the same gap repeatedly.
     */
    public function suggestForSkill(string $skillName): ?array
    {
        $cacheKey = 'course_suggestion:' . strtolower(trim($skillName));

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($skillName) {
            return $this->askGemini($skillName);
        });
    }

    private function askGemini(string $skillName): ?array
    {
               $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.6-flash');
        $prompt = <<<PROMPT
        A student is missing this skill/qualification: "{$skillName}".
        Suggest ONE real, well-known, free (or free-to-audit) online course that teaches this skill,
        from a real platform (Coursera, edX, freeCodeCamp, Khan Academy, Google, or similar).
        Respond ONLY with valid JSON, no markdown, no explanation, in this exact shape:
        {
          "course_title": "string",
          "platform": "string",
          "estimated_duration": "string, e.g. '4 hours' or '3 weeks'",
          "url": "string, a real, working URL to the course or platform search page"
        }
        If you are not confident of a real course, return the platform's search/homepage URL instead of a fake course URL.
        PROMPT;

        try {
            $response = Http::timeout(20)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'responseMimeType' => 'application/json',
                    ],
                ]
            );

            if (! $response->successful()) {
                Log::error('Gemini course suggestion failed', ['body' => $response->body()]);
                return null;
            }

            $text = $response->json('candidates.0.content.parts.0.text');
            $decoded = json_decode($text, true);

            if (! $decoded || empty($decoded['course_title'])) {
                Log::error('Gemini course suggestion: could not parse JSON', ['raw' => $text]);
                return null;
            }

            return $decoded;
        } catch (\Throwable $e) {
            Log::error('Gemini course suggestion exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}