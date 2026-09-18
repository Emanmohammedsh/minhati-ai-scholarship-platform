<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobOpportunity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $email = 'student@test.com'): User
    {
        return User::create([
            'role' => 'student',
            'full_name' => 'Test Student',
            'email' => $email,
            'password_hash' => bcrypt('password'),
            'is_active' => true,
        ]);
    }

    private function createJob(): JobOpportunity
    {
        return JobOpportunity::create([
            'title' => 'Junior Cyber Security Analyst',
            'company_name' => 'Jisr Demo Tech',
            'description' => 'Demo opportunity for testing.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'application_deadline' => '2026-10-15',
            'is_active' => true,
        ]);
    }

    public function test_user_can_save_a_job(): void
    {
        $user = $this->createUser();
        $job = $this->createJob();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/job-applications', [
            'job_id' => $job->job_id,
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('application.status', 'saved')
            ->assertJsonPath('application.job_id', $job->job_id);

        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->user_id,
            'job_id' => $job->job_id,
            'status' => 'saved',
        ]);
    }

    public function test_saving_same_job_twice_does_not_create_duplicate(): void
    {
        $user = $this->createUser();
        $job = $this->createJob();

        Sanctum::actingAs($user);

        $this->postJson('/api/job-applications', [
            'job_id' => $job->job_id,
        ])->assertCreated();

        $this->postJson('/api/job-applications', [
            'job_id' => $job->job_id,
        ])->assertOk();

        $this->assertDatabaseCount('job_applications', 1);
    }

    public function test_user_can_update_application_status_to_applied(): void
    {
        $user = $this->createUser();
        $job = $this->createJob();

        $application = JobApplication::create([
            'user_id' => $user->user_id,
            'job_id' => $job->job_id,
            'status' => 'saved',
        ]);

        Sanctum::actingAs($user);

        $response = $this->patchJson(
            "/api/job-applications/{$application->job_application_id}/status",
            [
                'status' => 'applied',
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath('application.status', 'applied');

        $application->refresh();

        $this->assertSame('applied', $application->status);
        $this->assertNotNull($application->applied_at);
    }

    public function test_user_can_move_application_to_interview(): void
    {
        $user = $this->createUser();
        $job = $this->createJob();

        $application = JobApplication::create([
            'user_id' => $user->user_id,
            'job_id' => $job->job_id,
            'status' => 'applied',
            'applied_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $this->patchJson(
            "/api/job-applications/{$application->job_application_id}/status",
            [
                'status' => 'interview',
            ]
        )
            ->assertOk()
            ->assertJsonPath('application.status', 'interview');

        $this->assertDatabaseHas('job_applications', [
            'job_application_id' => $application->job_application_id,
            'status' => 'interview',
        ]);
    }

    public function test_user_cannot_update_another_users_application(): void
    {
        $owner = $this->createUser('owner@test.com');
        $otherUser = $this->createUser('other@test.com');
        $job = $this->createJob();

        $application = JobApplication::create([
            'user_id' => $owner->user_id,
            'job_id' => $job->job_id,
            'status' => 'saved',
        ]);

        Sanctum::actingAs($otherUser);

        $this->patchJson(
            "/api/job-applications/{$application->job_application_id}/status",
            [
                'status' => 'applied',
            ]
        )->assertForbidden();

        $this->assertDatabaseHas('job_applications', [
            'job_application_id' => $application->job_application_id,
            'status' => 'saved',
        ]);
    }
}
