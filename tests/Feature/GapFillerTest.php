<?php

namespace Tests\Feature;

use App\Models\Cv;
use App\Models\JobOpportunity;
use App\Models\JobRecommendation;
use App\Models\JobRequirement;
use App\Models\JobRequirementMatch;
use App\Models\User;
use App\Services\CourseRecommendationService;
use App\Services\GapFillerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class GapFillerTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(
        string $email = 'student@test.com'
    ): User {
        return User::create([
            'role' => 'student',
            'full_name' => 'Test Student',
            'email' => $email,
            'password_hash' => 'password',
            'is_active' => true,
        ]);
    }

    private function createJob(): JobOpportunity
    {
        return JobOpportunity::create([
            'title' => 'Junior Cyber Security Analyst',
            'company_name' => 'Jisr Demo Tech',
            'description' => 'Demo cyber security job.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'is_active' => true,
        ]);
    }

    private function createCv(User $user): Cv
    {
        return Cv::create([
            'user_id' => $user->user_id,
            'original_filename' => 'test-cv.pdf',
            'stored_filename' => 'test-cv.pdf',
            'file_path' => 'cvs/test-cv.pdf',
            'mime_type' => 'application/pdf',
            'file_size_bytes' => 1000,
            'is_active' => true,
            'extraction_status' => 'completed',
            'extracted_skills' => [
                'Network Security',
                'Linux',
            ],
        ]);
    }

    private function createRecommendationData(
        User $user,
        bool $isSatisfied = false
    ): array {
        $job = $this->createJob();
        $cv = $this->createCv($user);

        $requirement = JobRequirement::create([
            'job_id' => $job->job_id,
            'requirement_type' => 'skill',
            'required_value' => 'Python',
            'is_mandatory' => false,
            'weight' => 30,
        ]);

        $recommendation = JobRecommendation::create([
            'user_id' => $user->user_id,
            'job_id' => $job->job_id,
            'cv_id' => $cv->cv_id,
            'match_score' => 70,
            'generated_at' => now(),
        ]);

        JobRequirementMatch::create([
            'job_recommendation_id' =>
                $recommendation->job_recommendation_id,

            'requirement_id' =>
                $requirement->requirement_id,

            'is_satisfied' => $isSatisfied,

            'contribution_points' =>
                $isSatisfied ? 30 : 0,
        ]);

        return [
            'job' => $job,
            'cv' => $cv,
            'requirement' => $requirement,
            'recommendation' => $recommendation,
        ];
    }

    public function test_user_can_generate_plan_for_real_gap(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            false
        );

        Sanctum::actingAs($user);

        $mock = Mockery::mock(
            GapFillerService::class
        );

        $mock->shouldReceive('generatePlan')
            ->once()
            ->with(
                'Junior Cyber Security Analyst',
                'skill',
                'Python',
                [
                    'Network Security',
                    'Linux',
                ]
            )
            ->andReturn([
                'source' => 'ai',
                'missing_requirement' => 'Python',
                'why_it_matters' =>
                    'Python supports security automation.',
                'learning_goal' =>
                    'Learn practical Python basics.',
                'steps' => [
                    'Learn Python syntax.',
                    'Practice functions.',
                    'Build a small security script.',
                ],
                'practice_task' =>
                    'Build a simple log parser.',
                'search_keywords' => [
                    'Python beginner course',
                ],
            ]);

        $this->app->instance(
            GapFillerService::class,
            $mock
        );

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['requirement']
                        ->requirement_id,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'current_match_score',
                70
            )
            ->assertJsonPath(
                'gap.required_value',
                'Python'
            )
            ->assertJsonPath(
                'learning_plan.source',
                'ai'
            )
            ->assertJsonPath(
                'learning_plan.learning_goal',
                'Learn practical Python basics.'
            );
    }

    public function test_user_cannot_use_another_users_recommendation(): void
    {
        $owner = $this->createUser(
            'owner@test.com'
        );

        $otherUser = $this->createUser(
            'other@test.com'
        );

        $data = $this->createRecommendationData(
            $owner,
            false
        );

        Sanctum::actingAs($otherUser);

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['requirement']
                        ->requirement_id,
            ]
        );

        $response->assertForbidden();
    }

    public function test_satisfied_requirement_cannot_use_gap_filler(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            true
        );

        Sanctum::actingAs($user);

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['requirement']
                        ->requirement_id,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonPath(
                'message',
                'This requirement is already satisfied.'
            );
    }

    public function test_requirement_must_belong_to_recommendation(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            false
        );

        $otherJob = JobOpportunity::create([
            'title' => 'Backend Developer',
            'company_name' => 'Jisr Demo Software',
            'is_active' => true,
        ]);

        $otherRequirement = JobRequirement::create([
            'job_id' => $otherJob->job_id,
            'requirement_type' => 'skill',
            'required_value' => 'Laravel',
            'is_mandatory' => false,
            'weight' => 20,
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $otherRequirement
                        ->requirement_id,
            ]
        );

        $response->assertNotFound();
    }

    /**
     * Builds a recommendation with TWO requirements so the
     * potential-match-score math is non-trivial to verify:
     *   - one already satisfied (weight 40, earns 40)
     *   - one unsatisfied gap being filled (weight 30, earns 0)
     * Total weight = 70, so:
     *   current_match_score  = persisted match_score (70, unrelated fixture value)
     *   potential_match_score = (40 + 30) / 70 * 100 = 100.0
     */
    private function createRecommendationWithTwoRequirements(
        User $user
    ): array {
        $job = $this->createJob();
        $cv = $this->createCv($user);

        $satisfiedRequirement = JobRequirement::create([
            'job_id' => $job->job_id,
            'requirement_type' => 'skill',
            'required_value' => 'Linux',
            'is_mandatory' => false,
            'weight' => 40,
        ]);

        $gapRequirement = JobRequirement::create([
            'job_id' => $job->job_id,
            'requirement_type' => 'skill',
            'required_value' => 'Python',
            'is_mandatory' => false,
            'weight' => 30,
        ]);

        $recommendation = JobRecommendation::create([
            'user_id' => $user->user_id,
            'job_id' => $job->job_id,
            'cv_id' => $cv->cv_id,
            'match_score' => 57.14,
            'generated_at' => now(),
        ]);

        JobRequirementMatch::create([
            'job_recommendation_id' =>
                $recommendation->job_recommendation_id,
            'requirement_id' =>
                $satisfiedRequirement->requirement_id,
            'is_satisfied' => true,
            'contribution_points' => 40,
        ]);

        JobRequirementMatch::create([
            'job_recommendation_id' =>
                $recommendation->job_recommendation_id,
            'requirement_id' =>
                $gapRequirement->requirement_id,
            'is_satisfied' => false,
            'contribution_points' => 0,
        ]);

        return [
            'job' => $job,
            'cv' => $cv,
            'gap_requirement' => $gapRequirement,
            'recommendation' => $recommendation,
        ];
    }

    public function test_potential_match_score_is_calculated_correctly(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationWithTwoRequirements(
            $user
        );

        Sanctum::actingAs($user);

        $gapFillerMock = Mockery::mock(
            GapFillerService::class
        );

        $gapFillerMock->shouldReceive('generatePlan')
            ->once()
            ->andReturn([
                'source' => 'ai',
                'missing_requirement' => 'Python',
                'why_it_matters' => 'Needed for automation.',
                'learning_goal' => 'Learn Python basics.',
                'steps' => ['Learn syntax.'],
                'practice_task' => 'Write a script.',
                'search_keywords' => ['Python beginner course'],
            ]);

        $this->app->instance(
            GapFillerService::class,
            $gapFillerMock
        );

        $courseMock = Mockery::mock(
            CourseRecommendationService::class
        );

        $courseMock->shouldReceive('suggestForSkill')
            ->once()
            ->with('Python')
            ->andReturn(null);

        $this->app->instance(
            CourseRecommendationService::class,
            $courseMock
        );

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['gap_requirement']
                        ->requirement_id,
            ]
        );

        /*
         * total weight = 40 + 30 = 70
         * potential earned = 40 (already satisfied) + 30 (this gap) = 70
         * potential_match_score = 70 / 70 * 100 = 100.0
         */
        $response
            ->assertOk()
            ->assertJsonPath(
                'current_match_score',
                57.14
            )            ->assertJsonPath(
                'potential_match_score',
                100
            )            ->assertJsonPath(
                'gap.weight',
                30
            );
    }

    public function test_recommended_course_is_included_when_available(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            false
        );

        Sanctum::actingAs($user);

        $gapFillerMock = Mockery::mock(
            GapFillerService::class
        );

        $gapFillerMock->shouldReceive('generatePlan')
            ->once()
            ->andReturn([
                'source' => 'ai',
                'missing_requirement' => 'Python',
                'why_it_matters' => 'Needed for automation.',
                'learning_goal' => 'Learn Python basics.',
                'steps' => ['Learn syntax.'],
                'practice_task' => 'Write a script.',
                'search_keywords' => ['Python beginner course'],
            ]);

        $this->app->instance(
            GapFillerService::class,
            $gapFillerMock
        );

        $courseMock = Mockery::mock(
            CourseRecommendationService::class
        );

        $courseMock->shouldReceive('suggestForSkill')
            ->once()
            ->with('Python')
            ->andReturn([
                'course_title' => 'Python for Everybody',
                'platform' => 'Coursera',
                'estimated_duration' => 'Self-paced',
                'url' => 'https://www.coursera.org/specializations/python',
            ]);

        $this->app->instance(
            CourseRecommendationService::class,
            $courseMock
        );

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['requirement']
                        ->requirement_id,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'recommended_course.course_title',
                'Python for Everybody'
            )
            ->assertJsonPath(
                'recommended_course.platform',
                'Coursera'
            );
    }

    public function test_gap_filler_still_works_when_no_course_is_found(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            false
        );

        Sanctum::actingAs($user);

        $gapFillerMock = Mockery::mock(
            GapFillerService::class
        );

        $gapFillerMock->shouldReceive('generatePlan')
            ->once()
            ->andReturn([
                'source' => 'ai',
                'missing_requirement' => 'Python',
                'why_it_matters' => 'Needed for automation.',
                'learning_goal' => 'Learn Python basics.',
                'steps' => ['Learn syntax.'],
                'practice_task' => 'Write a script.',
                'search_keywords' => ['Python beginner course'],
            ]);

        $this->app->instance(
            GapFillerService::class,
            $gapFillerMock
        );

        $courseMock = Mockery::mock(
            CourseRecommendationService::class
        );

        // Simulates a Gemini failure / missing API key.
        $courseMock->shouldReceive('suggestForSkill')
            ->once()
            ->with('Python')
            ->andReturn(null);

        $this->app->instance(
            CourseRecommendationService::class,
            $courseMock
        );

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            [
                'requirement_id' =>
                    $data['requirement']
                        ->requirement_id,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'recommended_course',
                null
            );
    }

    public function test_requirement_id_is_required(): void
    {
        $user = $this->createUser();

        $data = $this->createRecommendationData(
            $user,
            false
        );

        Sanctum::actingAs($user);

        $response = $this->postJson(
            '/api/job-recommendations/'
            . $data['recommendation']
                ->job_recommendation_id
            . '/gap-filler',
            []
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'requirement_id',
            ]);
    }
}
