<?php

namespace Tests\Feature;

use App\Models\Cv;
use App\Models\JobOpportunity;
use App\Models\JobRecommendation;
use App\Models\JobRequirement;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\JobMatchingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobMatchingTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $email = 'student@test.com'): User
    {
        return User::create([
            'role' => 'student',
            'full_name' => 'Test Student',
            'email' => $email,
            'password_hash' => 'password',
            'is_active' => true,
        ]);
    }

    private function createProfile(User $user): StudentProfile
    {
        return StudentProfile::create([
            'user_id' => $user->user_id,
            'academic_background' => 'Cyber Security Student',
            'field_of_study' => 'Cyber Security',
            'degree_level' => 'Bachelor',
            'interests' => 'Cybersecurity, Networking, AI',
            'country' => 'Palestine, State of',
        ]);
    }

    private function createCv(User $user): Cv
    {
        return Cv::create([
            'user_id' => $user->user_id,
            'file_path' => 'cvs/test.pdf',
            'original_filename' => 'test.pdf',
            'file_size_bytes' => 1000,
            'mime_type' => 'application/pdf',
            'is_active' => true,
            'extraction_status' => 'completed',

            'extracted_skills' => [
                'Network Security',
                'Linux',
            ],

            'extracted_qualifications' => [
                'Cyber Security',
            ],

            'extracted_education' => [
                [
                    'degree' => 'Bachelor',
                    'institution' => 'UCAS',
                ],
            ],

            'reviewed_by_student' => true,
        ]);
    }

    private function createJob(
        string $title,
        string $company = 'Jisr Demo Company'
    ): JobOpportunity {
        return JobOpportunity::create([
            'title' => $title,
            'company_name' => $company,
            'description' => 'Demo job for automated testing.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'is_active' => true,
        ]);
    }

    private function addRequirement(
        JobOpportunity $job,
        string $type,
        string $value,
        float $weight,
        bool $mandatory = false
    ): JobRequirement {
        return JobRequirement::create([
            'job_id' => $job->job_id,
            'requirement_type' => $type,
            'required_value' => $value,
            'is_mandatory' => $mandatory,
            'weight' => $weight,
        ]);
    }

    public function test_matching_score_is_calculated_from_satisfied_requirements(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $job = $this->createJob(
            'Junior Cyber Security Analyst'
        );

        $this->addRequirement(
            $job,
            'field_of_study',
            'Cyber Security',
            40
        );

        $this->addRequirement(
            $job,
            'skill',
            'Network Security',
            30
        );

        $this->addRequirement(
            $job,
            'skill',
            'Python',
            30
        );

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $this->assertCount(1, $recommendations);

        $recommendation = $recommendations->first();

        // 40 + 30 satisfied out of 100 total.
        $this->assertEquals(
            70.00,
            (float) $recommendation->match_score
        );

        $this->assertDatabaseHas(
            'job_recommendations',
            [
                'user_id' => $user->user_id,
                'job_id' => $job->job_id,
                'match_score' => 70.00,
            ]
        );
    }

    public function test_requirement_matches_are_saved_for_gap_analysis(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $job = $this->createJob(
            'Network Security Assistant'
        );

        $networkRequirement = $this->addRequirement(
            $job,
            'skill',
            'Network Security',
            60
        );

        $pythonRequirement = $this->addRequirement(
            $job,
            'skill',
            'Python',
            40
        );

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $recommendation = $recommendations->first();

        $this->assertDatabaseHas(
            'job_requirement_matches',
            [
                'job_recommendation_id'
                    => $recommendation->job_recommendation_id,

                'requirement_id'
                    => $networkRequirement->requirement_id,

                'is_satisfied' => true,

                'contribution_points' => 60.00,
            ]
        );

        $this->assertDatabaseHas(
            'job_requirement_matches',
            [
                'job_recommendation_id'
                    => $recommendation->job_recommendation_id,

                'requirement_id'
                    => $pythonRequirement->requirement_id,

                'is_satisfied' => false,

                'contribution_points' => 0.00,
            ]
        );
    }

    public function test_unmet_mandatory_requirement_disqualifies_job(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $job = $this->createJob(
            'Backend Developer'
        );

        $this->addRequirement(
            $job,
            'field_of_study',
            'Cyber Security',
            50
        );

        $this->addRequirement(
            $job,
            'skill',
            'Python',
            50,
            true
        );

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $this->assertCount(0, $recommendations);

        $this->assertDatabaseMissing(
            'job_recommendations',
            [
                'user_id' => $user->user_id,
                'job_id' => $job->job_id,
            ]
        );
    }

    public function test_recommendations_are_sorted_by_highest_score(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $highJob = $this->createJob(
            'High Match Job'
        );

        $this->addRequirement(
            $highJob,
            'field_of_study',
            'Cyber Security',
            80
        );

        $this->addRequirement(
            $highJob,
            'skill',
            'Python',
            20
        );

        $lowJob = $this->createJob(
            'Lower Match Job'
        );

        $this->addRequirement(
            $lowJob,
            'field_of_study',
            'Cyber Security',
            50
        );

        $this->addRequirement(
            $lowJob,
            'skill',
            'Python',
            50
        );

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $this->assertCount(2, $recommendations);

        $this->assertEquals(
            80.00,
            (float) $recommendations[0]->match_score
        );

        $this->assertEquals(
            50.00,
            (float) $recommendations[1]->match_score
        );

        $this->assertSame(
            $highJob->job_id,
            $recommendations[0]->job_id
        );

        $this->assertSame(
            $lowJob->job_id,
            $recommendations[1]->job_id
        );
    }

    public function test_regenerating_recommendations_does_not_create_duplicates(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $job = $this->createJob(
            'SOC Analyst'
        );

        $this->addRequirement(
            $job,
            'field_of_study',
            'Cyber Security',
            100
        );

        $service = app(
            JobMatchingService::class
        );

        $service->generate($user);
        $service->generate($user);

        $this->assertDatabaseCount(
            'job_recommendations',
            1
        );

        $this->assertDatabaseHas(
            'job_recommendations',
            [
                'user_id' => $user->user_id,
                'job_id' => $job->job_id,
            ]
        );
    }

    public function test_unsupported_requirement_type_is_not_assumed_satisfied(): void
    {
        $user = $this->createUser();
        $this->createProfile($user);
        $this->createCv($user);

        $job = $this->createJob(
            'Security Analyst'
        );

        $this->addRequirement(
            $job,
            'field_of_study',
            'Cyber Security',
            70
        );

        /*
         * Experience is intentionally unsupported by
         * JobMatchingService until reliable structured
         * experience data exists.
         */
        $this->addRequirement(
            $job,
            'experience',
            '2 years',
            30
        );

        $recommendations = app(
            JobMatchingService::class
        )->generate($user);

        $this->assertCount(1, $recommendations);

        $this->assertEquals(
            70.00,
            (float) $recommendations->first()->match_score
        );
    }
}
