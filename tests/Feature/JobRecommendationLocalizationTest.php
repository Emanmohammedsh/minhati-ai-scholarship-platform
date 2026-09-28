<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\JobRecommendationController;
use App\Models\Cv;
use App\Models\JobOpportunity;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\JobMatchingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class JobRecommendationLocalizationTest extends TestCase
{
    use RefreshDatabase;

    private function createRecommendation(
        bool $withTranslations = true
    ): array {
        $user = User::create([
            'role' => 'student',
            'full_name' => 'Localization Test Student',
            'email' => 'localization@test.com',
            'password_hash' => 'password',
            'is_active' => true,
        ]);

        StudentProfile::create([
            'user_id' => $user->user_id,
            'academic_background' => 'Cyber Security Student',
            'field_of_study' => 'Cyber Security',
            'degree_level' => 'Bachelor',
            'interests' => 'Cybersecurity',
            'country' => 'Palestine, State of',
        ]);

        Cv::create([
            'user_id' => $user->user_id,
            'file_path' => 'cvs/localization-test.pdf',
            'original_filename' => 'localization-test.pdf',
            'file_size_bytes' => 1000,
            'mime_type' => 'application/pdf',
            'is_active' => true,
            'extraction_status' => 'completed',
            'extracted_skills' => ['Network Security'],
            'extracted_qualifications' => ['Cyber Security'],
            'extracted_education' => [
                [
                    'degree' => 'Bachelor',
                    'institution' => 'UCAS',
                ],
            ],
            'reviewed_by_student' => true,
        ]);

        $job = JobOpportunity::create([
            'title' => 'Junior Cyber Security Analyst',
            'company_name' => 'Jisr Demo Tech',
            'description' => 'Original English job description.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'is_active' => true,
        ]);

        $job->requirements()->create([
            'requirement_type' => 'skill',
            'required_value' => 'Network Security',
            'is_mandatory' => false,
            'weight' => 100,
        ]);

        if ($withTranslations) {
            $job->translations()->createMany([
                [
                    'locale' => 'ar',
                    'title' => 'محلل أمن سيبراني مبتدئ',
                    'description' => 'وصف الوظيفة باللغة العربية.',
                ],
                [
                    'locale' => 'en',
                    'title' => 'Junior Cyber Security Analyst',
                    'description' => 'English translated job description.',
                ],
            ]);
        }

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $this->assertCount(1, $recommendations);

        return [$user, $job];
    }

    /**
     * Call the real recommendation controller.
     * This verifies its JSON output without assuming
     * an API route name or authentication guard.
     */
    private function recommendationResponse(
        User $user,
        string $locale
    ): array {
        app()->setLocale($locale);

        $request = Request::create(
            '/api/job-recommendations',
            'GET'
        );

        $request->setUserResolver(
            fn () => $user
        );

        $controller = app(
            JobRecommendationController::class
        );

        return $controller->index($request)->getData(true);
    }

    public function test_arabic_job_translation_is_returned(): void
    {
        [$user, $job] = $this->createRecommendation();

        $response = $this->recommendationResponse(
            $user,
            'ar'
        );

        $this->assertSame(1, $response['count']);

        $result = $response['recommendations'][0]['job'];

        $this->assertSame(
            'محلل أمن سيبراني مبتدئ',
            $result['title']
        );

        $this->assertSame(
            'وصف الوظيفة باللغة العربية.',
            $result['description']
        );

        $this->assertSame(
            'Jisr Demo Tech',
            $result['company_name']
        );

        $this->assertSame('Gaza', $result['city']);
        $this->assertSame('Hybrid', $result['work_mode']);

        $this->assertArrayNotHasKey(
            'translations',
            $result
        );

        $this->assertDatabaseHas(
            'job_opportunities',
            [
                'job_id' => $job->job_id,
                'title' => 'Junior Cyber Security Analyst',
            ]
        );
    }

    public function test_english_job_translation_is_returned(): void
    {
        [$user] = $this->createRecommendation();

        $response = $this->recommendationResponse(
            $user,
            'en'
        );

        $result = $response['recommendations'][0]['job'];

        $this->assertSame(
            'Junior Cyber Security Analyst',
            $result['title']
        );

        $this->assertSame(
            'English translated job description.',
            $result['description']
        );

        $this->assertSame(
            'Jisr Demo Tech',
            $result['company_name']
        );
    }

    public function test_missing_translation_falls_back_to_original_job(): void
    {
        [$user] = $this->createRecommendation(false);

        $response = $this->recommendationResponse(
            $user,
            'ar'
        );

        $result = $response['recommendations'][0]['job'];

        $this->assertSame(
            'Junior Cyber Security Analyst',
            $result['title']
        );

        $this->assertSame(
            'Original English job description.',
            $result['description']
        );
    }

    public function test_localization_does_not_change_match_score(): void
    {
        [$user] = $this->createRecommendation();

        $arabic = $this->recommendationResponse(
            $user,
            'ar'
        );

        $english = $this->recommendationResponse(
            $user,
            'en'
        );

        $this->assertEquals(
            $arabic['recommendations'][0]['match_score'],
            $english['recommendations'][0]['match_score']
        );

        $this->assertEquals(
            100,
            $arabic['recommendations'][0]['match_score']
        );
    }
}
