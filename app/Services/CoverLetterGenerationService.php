<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Scholarship;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoverLetterGenerationService
{
    public function generate(
        User $user,
        Scholarship $scholarship,
        ?StudentProfile $profile,
        ?Cv $cv
    ): string {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3.5-flash');

        if (! $apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY is not configured.');
        }

        $skills = $cv?->extracted_skills ?? [];
        $education = $cv?->extracted_education ?? [];
        $qualifications = $cv?->extracted_qualifications ?? [];

        $profileData = [
            'name' => $user->full_name,
            'academic_background' => $profile?->academic_background,
            'field_of_study' => $profile?->field_of_study,
            'degree_level' => $profile?->degree_level,
            'interests' => $profile?->interests,
            'country' => $profile?->country,
            'skills' => $skills,
            'education' => $education,
            'qualifications' => $qualifications,
        ];

        $scholarshipData = [
            'title' => $scholarship->title,
            'provider' => $scholarship->provider_name,
            'description' => $scholarship->description,
            'country' => $scholarship->country,
            'field_of_study' => $scholarship->field_of_study,
            'degree_level' => $scholarship->degree_level,
            'deadline' => $scholarship->application_deadline,
        ];

        $prompt = <<<PROMPT
Write a professional scholarship cover letter for the student below.

Use only the information provided.
Do not invent achievements, experience, education, skills, or qualifications.
The letter should be professional, clear, personalized, and suitable for a scholarship application.
Keep it concise and approximately 300-450 words.

STUDENT INFORMATION:
{$this->toJson($profileData)}

SCHOLARSHIP INFORMATION:
{$this->toJson($scholarshipData)}

Return only the final cover letter text without explanations, markdown, headings, or JSON.
PROMPT;

        $response = Http::timeout(30)
            ->withHeaders([
                'x-goog-api-key' => $apiKey,
            ])
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.6,
                    ],
                ]
            );

        if ($response->failed()) {
            Log::error('Gemini cover letter generation failed', [
                'user_id' => $user->user_id,
                'scholarship_id' => $scholarship->scholarship_id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException(
                'Gemini API request failed: ' . $response->status()
            );
        }

        $content = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text'
        );

        if (! $content || trim($content) === '') {
            throw new \RuntimeException(
                'Gemini API returned no cover letter content.'
            );
        }

        return trim($content);
    }

    private function toJson(array $data): string
    {
        return json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
}
