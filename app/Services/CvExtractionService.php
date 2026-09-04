<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class CvExtractionService
{
    /**
     * FR-07: extract skills, education, and qualifications from an
     * uploaded CV using an external AI service (Google Gemini).
     */
    public function extract(Cv $cv): array
    {
        $text = $this->readPdfText($cv);

        // FR-07 alt scenario: no detectable text — leave fields empty
        // rather than calling the AI on nothing / fabricating data.
        if (trim($text) === '') {
            Log::info('CV extraction skipped — no extractable text', [
                'cv_id' => $cv->cv_id,
            ]);

            return [
                'skills' => [],
                'education' => [],
                'qualifications' => [],
            ];
        }

        return $this->extractWithGemini($text, $cv);
    }

    private function readPdfText(Cv $cv): string
    {
        $absolutePath = Storage::disk('local')->path($cv->file_path);
        $parser = new Parser();
        $pdf = $parser->parseFile($absolutePath);

        return $pdf->getText();
    }

    /**
     * Calls Gemini's generateContent endpoint with a JSON response schema
     * so the model returns structured data directly — no manual parsing
     * of free-text output required.
     */
    private function extractWithGemini(string $cvText, Cv $cv): array
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.5-flash');

        if (! $apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY is not configured.');
        }

        $schema = [
            'type' => 'object',
            'properties' => [
                'skills' => [
                    'type' => 'array',
                    'items' => ['type' => 'string'],
                    'description' => 'Technical and professional skills mentioned in the CV.',
                ],
                'education' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'degree' => ['type' => 'string'],
                            'institution' => ['type' => 'string'],
                            'year' => ['type' => 'string'],
                        ],
                    ],
                    'description' => 'Educational background entries. Empty array if none found.',
                ],
                'qualifications' => [
                    'type' => 'array',
                    'items' => ['type' => 'string'],
                    'description' => 'Certifications, qualifications, or notable achievements.',
                ],
            ],
            'required' => ['skills', 'education', 'qualifications'],
        ];

        $prompt = <<<PROMPT
        Extract structured information from the following CV text. Only
        include information that is explicitly present in the text — do
        not infer or fabricate anything. If a category has no matching
        content, return an empty array for it.

        CV TEXT:
        {$cvText}
        PROMPT;

        // FR-07 acceptance criterion: return within 30 seconds. NFR-02
        // backs this with a 30s timeout so a hung request fails fast
        // instead of blocking the student indefinitely.
        $response = Http::timeout(30)
            ->withHeaders(['x-goog-api-key' => $apiKey])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'responseSchema' => $schema,
                ],
            ]);

        if ($response->failed()) {
            Log::error('Gemini extraction request failed', [
                'cv_id' => $cv->cv_id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Gemini API request failed: ' . $response->status());
        }

        $rawText = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! $rawText) {
            throw new \RuntimeException('Gemini API returned no content.');
        }

        $parsed = json_decode($rawText, true);

        if (! is_array($parsed)) {
            throw new \RuntimeException('Gemini API returned invalid JSON.');
        }

        return [
            'skills' => $parsed['skills'] ?? [],
            'education' => $parsed['education'] ?? [],
            'qualifications' => $parsed['qualifications'] ?? [],
        ];
    }
}