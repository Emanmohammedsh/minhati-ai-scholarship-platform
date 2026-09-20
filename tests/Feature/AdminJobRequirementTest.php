<?php

namespace Tests\Feature;

use App\Models\JobOpportunity;
use App\Models\JobRequirement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminJobRequirementTest extends TestCase
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

    private function createJob(
        string $title = 'Junior Security Analyst'
    ): JobOpportunity {
        return JobOpportunity::create([
            'title' => $title,
            'company_name' => 'Jisr Demo Tech',
            'description' => 'Demo job for testing.',
            'country' => 'Palestine, State of',
            'city' => 'Gaza',
            'employment_type' => 'Full Time',
            'work_mode' => 'Hybrid',
            'minimum_experience_years' => 0,
            'is_active' => true,
        ]);
    }

    private function createRequirement(
        JobOpportunity $job
    ): JobRequirement {
        return JobRequirement::create([
            'job_id' => $job->job_id,
            'requirement_type' => 'skill',
            'required_value' => 'Network Security',
            'is_mandatory' => true,
            'weight' => 50,
        ]);
    }

    public function test_admin_can_list_job_requirements(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        $this->createRequirement($job);

        Sanctum::actingAs($admin);

        $response = $this->getJson(
            "/api/admin/jobs/{$job->job_id}/requirements"
        );

        $response
            ->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath(
                'requirements.0.required_value',
                'Network Security'
            );
    }

    public function test_admin_can_create_job_requirement(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->postJson(
            "/api/admin/jobs/{$job->job_id}/requirements",
            [
                'requirement_type' => 'skill',
                'required_value' => 'Python',
                'is_mandatory' => false,
                'weight' => 30,
            ]
        );

        $response
            ->assertCreated()
            ->assertJsonPath(
                'requirement.requirement_type',
                'skill'
            )
            ->assertJsonPath(
                'requirement.required_value',
                'Python'
            );

        $this->assertDatabaseHas(
            'job_requirements',
            [
                'job_id' => $job->job_id,
                'requirement_type' => 'skill',
                'required_value' => 'Python',
                'is_mandatory' => false,
            ]
        );
    }

    public function test_admin_can_update_job_requirement(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();
        $requirement = $this->createRequirement($job);

        Sanctum::actingAs($admin);

        $response = $this->putJson(
            "/api/admin/jobs/{$job->job_id}/requirements/{$requirement->requirement_id}",
            [
                'required_value' => 'Linux',
                'weight' => 40,
                'is_mandatory' => false,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'requirement.required_value',
                'Linux'
            );

        $this->assertDatabaseHas(
            'job_requirements',
            [
                'requirement_id'
                    => $requirement->requirement_id,

                'required_value' => 'Linux',
                'weight' => 40,
                'is_mandatory' => false,
            ]
        );
    }

    public function test_admin_can_delete_job_requirement(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();
        $requirement = $this->createRequirement($job);

        Sanctum::actingAs($admin);

        $response = $this->deleteJson(
            "/api/admin/jobs/{$job->job_id}/requirements/{$requirement->requirement_id}"
        );

        $response->assertOk();

        $this->assertDatabaseMissing(
            'job_requirements',
            [
                'requirement_id'
                    => $requirement->requirement_id,
            ]
        );
    }

    public function test_requirement_cannot_be_accessed_through_wrong_job(): void
    {
        $admin = $this->createAdmin();

        $firstJob = $this->createJob('First Job');
        $secondJob = $this->createJob('Second Job');

        $requirement = $this->createRequirement(
            $firstJob
        );

        Sanctum::actingAs($admin);

        $this->getJson(
            "/api/admin/jobs/{$secondJob->job_id}/requirements/{$requirement->requirement_id}"
        )->assertNotFound();

        $this->putJson(
            "/api/admin/jobs/{$secondJob->job_id}/requirements/{$requirement->requirement_id}",
            [
                'required_value' => 'Python',
            ]
        )->assertNotFound();

        $this->deleteJson(
            "/api/admin/jobs/{$secondJob->job_id}/requirements/{$requirement->requirement_id}"
        )->assertNotFound();

        $this->assertDatabaseHas(
            'job_requirements',
            [
                'requirement_id'
                    => $requirement->requirement_id,

                'job_id' => $firstJob->job_id,

                'required_value'
                    => 'Network Security',
            ]
        );
    }

    public function test_student_cannot_manage_job_requirements(): void
    {
        $student = $this->createStudent();
        $job = $this->createJob();
        $requirement = $this->createRequirement($job);

        Sanctum::actingAs($student);

        $this->getJson(
            "/api/admin/jobs/{$job->job_id}/requirements"
        )->assertForbidden();

        $this->postJson(
            "/api/admin/jobs/{$job->job_id}/requirements",
            [
                'requirement_type' => 'skill',
                'required_value' => 'Python',
                'weight' => 30,
            ]
        )->assertForbidden();

        $this->putJson(
            "/api/admin/jobs/{$job->job_id}/requirements/{$requirement->requirement_id}",
            [
                'required_value' => 'Python',
            ]
        )->assertForbidden();

        $this->deleteJson(
            "/api/admin/jobs/{$job->job_id}/requirements/{$requirement->requirement_id}"
        )->assertForbidden();
    }

    public function test_requirement_validation_rejects_invalid_data(): void
    {
        $admin = $this->createAdmin();
        $job = $this->createJob();

        Sanctum::actingAs($admin);

        $response = $this->postJson(
            "/api/admin/jobs/{$job->job_id}/requirements",
            [
                'requirement_type' => 'invalid_type',
                'required_value' => '',
                'weight' => 150,
            ]
        );

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'requirement_type',
                'required_value',
                'weight',
            ]);

        $this->assertDatabaseCount(
            'job_requirements',
            0
        );
    }
}
