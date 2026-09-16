<?php

namespace Tests\Feature;

use App\Models\JobOpportunity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminJobManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::create([
            'role' => 'admin',
            'full_name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password_hash' => 'password',
            'is_active' => true,
        ]);
    }

    private function createStudent(): User
    {
        return User::create([
            'role' => 'student',
            'full_name' => 'Test Student',
            'email' => 'student@test.com',
            'password_hash' => 'password',
            'is_active' => true,
        ]);
    }

    private function createJob(): JobOpportunity
    {
        return JobOpportunity::create([
            'title' => 'Junior Security Analyst',
            'company_name' => 'Jisr Demo Tech',
            'description' => 'Demo job for testing.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'application_deadline' => '2026-10-30',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_list_jobs(): void
    {
        $admin = $this->createAdmin();

        $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/admin/jobs');

        $response
            ->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath(
                'jobs.0.title',
                'Junior Security Analyst'
            );
    }

    public function test_admin_can_create_job(): void
    {
        $admin = $this->createAdmin();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/admin/jobs', [
            'title' => 'SOC Analyst Intern',
            'company_name' => 'Jisr Demo Security',
            'description' => 'Entry-level SOC opportunity.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Internship',
            'work_mode' => 'On-site',
            'minimum_experience_years' => 0,
            'application_deadline' => '2026-11-15',
            'is_active' => true,
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath(
                'job.title',
                'SOC Analyst Intern'
            );

        $this->assertDatabaseHas(
            'job_opportunities',
            [
                'title' => 'SOC Analyst Intern',
                'company_name' => 'Jisr Demo Security',
                'is_active' => true,
            ]
        );
    }

    public function test_admin_can_update_job(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->putJson(
            "/api/admin/jobs/{$job->job_id}",
            [
                'title' => 'Updated Security Analyst',
                'work_mode' => 'Remote',
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'job.title',
                'Updated Security Analyst'
            )
            ->assertJsonPath(
                'job.work_mode',
                'Remote'
            );

        $this->assertDatabaseHas(
            'job_opportunities',
            [
                'job_id' => $job->job_id,
                'title' => 'Updated Security Analyst',
                'work_mode' => 'Remote',
            ]
        );
    }

    public function test_admin_can_deactivate_job(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->patchJson(
            "/api/admin/jobs/{$job->job_id}/status",
            [
                'is_active' => false,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'job.is_active',
                false
            );

        $this->assertDatabaseHas(
            'job_opportunities',
            [
                'job_id' => $job->job_id,
                'is_active' => false,
            ]
        );
    }

    public function test_admin_can_delete_job(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson(
            "/api/admin/jobs/{$job->job_id}"
        );

        $response->assertOk();

        $this->assertDatabaseMissing(
            'job_opportunities',
            [
                'job_id' => $job->job_id,
            ]
        );
    }

    public function test_student_cannot_access_admin_job_management(): void
    {
        $student = $this->createStudent();
        $job = $this->createJob();

        Sanctum::actingAs($student);

        $this->getJson('/api/admin/jobs')
            ->assertForbidden();

        $this->postJson('/api/admin/jobs', [
            'title' => 'Unauthorized Job',
            'company_name' => 'Unauthorized Company',
        ])->assertForbidden();

        $this->putJson(
            "/api/admin/jobs/{$job->job_id}",
            [
                'title' => 'Unauthorized Update',
            ]
        )->assertForbidden();

        $this->patchJson(
            "/api/admin/jobs/{$job->job_id}/status",
            [
                'is_active' => false,
            ]
        )->assertForbidden();

        $this->deleteJson(
            "/api/admin/jobs/{$job->job_id}"
        )->assertForbidden();

        $this->assertDatabaseHas(
            'job_opportunities',
            [
                'job_id' => $job->job_id,
                'title' => 'Junior Security Analyst',
                'is_active' => true,
            ]
        );
    }

    public function test_job_creation_requires_title_and_company_name(): void
    {
        $admin = $this->createAdmin();

        Sanctum::actingAs($admin);

        $response = $this->postJson(
            '/api/admin/jobs',
            []
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'title',
                'company_name',
            ]);

        $this->assertDatabaseCount(
            'job_opportunities',
            0
        );
    }
}
