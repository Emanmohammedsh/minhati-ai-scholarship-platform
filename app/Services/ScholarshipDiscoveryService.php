<?php

namespace App\Services;

use App\Models\Scholarship;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScholarshipDiscoveryService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.key');
        $this->model = (string) config('services.gemini.model', 'gemini-2.0-flash');

        if ($this->apiKey === '') {
            throw new \RuntimeException('GEMINI_API_KEY is not set. Add it to your .env file.');
        }
    }

    public function discoverAndStore(int $limit = 10): array
    {
        $existingTitles = Scholarship::pluck('title')->map(fn ($t) => mb_strtolower(trim($t)))->all();

        $prompt = $this->buildPrompt($limit, $existingTitles);

        $response = Http::timeout(60)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $prompt]]],
                ],
                // Enable real web search grounding so the model can actually
                // browse for current scholarships instead of guessing.
                'tools' => [
                    ['google_search' => new \stdClass()],
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                ],
            ]
        );

        if (! $response->successful()) {
            Log::error('Gemini scholarship discovery failed', ['body' => $response->body()]);
            return ['added' => 0, 'skipped' => 0, 'errors' => [$response->body()]];
        }

        $json = $response->json();
        $text = data_get($json, 'candidates.0.content.parts.0.text', '');

        if (trim($text) === '') {
            // Log the full response so we can see finishReason / safety
            // ratings / block reason instead of just an empty string.
            $finishReason = data_get($json, 'candidates.0.finishReason');
            $safetyRatings = data_get($json, 'candidates.0.safetyRatings');
            $promptFeedback = data_get($json, 'promptFeedback');

            Log::error('Gemini scholarship discovery: empty text in response', [
                'finishReason'   => $finishReason,
                'safetyRatings'  => $safetyRatings,
                'promptFeedback' => $promptFeedback,
                'full_response'  => $json,
            ]);

            return ['added' => 0, 'skipped' => 0, 'errors' => [
                'Gemini returned an empty response (finishReason: ' . ($finishReason ?? 'unknown') . '). Check laravel.log for details.',
            ]];
        }

        $items = $this->extractJson($text);

        if ($items === null) {
            Log::error('Gemini scholarship discovery: could not parse JSON', ['raw' => $text]);
            return ['added' => 0, 'skipped' => 0, 'errors' => ['Could not parse model response as JSON.']];
        }

        $added = 0;
        $skipped = 0;
        $errors = [];
        $today = now()->startOfDay();

        foreach ($items as $item) {
            try {
                $title = trim($item['title'] ?? '');
                $provider = trim($item['provider_name'] ?? '');

                if ($title === '' || $provider === '') {
                    $skipped++;
                    continue;
                }

                $isDuplicate = Scholarship::whereRaw('LOWER(title) = ?', [mb_strtolower($title)])
                    ->whereRaw('LOWER(provider_name) = ?', [mb_strtolower($provider)])
                    ->exists();

                if ($isDuplicate) {
                    $skipped++;
                    continue;
                }

                // Safety net: even if the model ignores the prompt instructions,
                // never store a scholarship whose deadline has already passed.
                $deadlineRaw = $item['application_deadline'] ?? null;
                $deadline = null;

                if ($deadlineRaw) {
                    try {
                        $parsed = \Carbon\Carbon::parse($deadlineRaw)->startOfDay();
                        if ($parsed->lessThan($today)) {
                            $skipped++;
                            continue;
                        }
                        $deadline = $parsed->toDateString();
                    } catch (\Throwable $e) {
                        // Unparseable date — treat as no fixed deadline rather than reject.
                        $deadline = null;
                    }
                }

                Scholarship::create([
                    'title'                => $title,
                    'provider_name'        => $provider,
                    'description'          => $item['description'] ?? null,
                    'country'              => $item['country'] ?? null,
                    'field_of_study'       => $item['field_of_study'] ?? null,
                    'degree_level'         => $item['degree_level'] ?? null,
                    'application_deadline' => $deadline,
                    'external_link'        => $item['external_link'] ?? null,
                    'created_by_admin_id'  => null,
                    'is_active'            => false, // pending review
                ]);

                $added++;
            } catch (\Throwable $e) {
                $errors[] = $e->getMessage();
            }
        }

        return ['added' => $added, 'skipped' => $skipped, 'errors' => $errors];
    }

    protected function buildPrompt(int $limit, array $existingTitles): string
    {
        $existingList = implode("\n", array_map(fn ($t) => "- {$t}", $existingTitles));
        $today = now()->toDateString();

        return <<<PROMPT
Search the web for real, currently OPEN scholarships relevant to Palestinian or Gaza-affected students (any degree level, any country). Use Google Search to verify each one is real and currently listed on an official or reputable source (university site, government site, NGO site) — do not invent any scholarship.

Today's date is {$today}. This is critical: only include a scholarship if either:
(a) its application deadline is clearly AFTER {$today}, or
(b) it is an ongoing/rolling scholarship with no fixed deadline (in which case set application_deadline to null).

Do NOT include any scholarship whose application deadline has already passed relative to {$today}. If you find a scholarship that looks relevant but you cannot confirm a current, still-open deadline, either search for its next upcoming cycle or leave it out entirely — do not guess or reuse an old date.

Return up to {$limit} scholarships that are NOT already in this list (case-insensitive match on title):
{$existingList}

Respond with ONLY a raw JSON array (no markdown, no code fences, no explanation) where each object has exactly these fields:
[
  {
    "title": "string",
    "provider_name": "string",
    "description": "string, 1-2 sentences",
    "country": "string or null",
    "field_of_study": "string or null",
    "degree_level": "bachelor|master|phd or null",
    "application_deadline": "YYYY-MM-DD (must be after {$today}) or null if rolling/no fixed deadline",
    "external_link": "string URL or null"
  }
]

If you cannot verify any new real scholarships with a currently open deadline, return an empty array: []
PROMPT;
    }

    protected function extractJson(string $text): ?array
    {
        $text = trim($text);
        $text = preg_replace('/^```(?:json)?/', '', $text);
        $text = preg_replace('/```$/', '', $text);
        $text = trim($text);

        $decoded = json_decode($text, true);
        return is_array($decoded) ? $decoded : null;
    }
}