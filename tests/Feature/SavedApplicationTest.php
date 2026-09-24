<?php

namespace Tests\Feature;

use App\Models\SavedApplication;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SavedApplicationTest extends TestCase
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

    private function createScholarship(string $title = 'Test Scholarship'): Scholarship
    {
        return Scholarship::create([
            'title' => $title,
            'provider_name' => 'Test Provider',
            'description' => 'Demo scholarship for testing.',
            'country' => 'Germany',
            'field_of_study' => 'Computer Science',
            'degree_level' => 'Master',
            'application_deadline' => '2026-12-01',
            'external_link' => 'https://example.com/scholarship',
            'is_active' => true,
        ]);
    }

    public function test_apply_on_new_scholarship_creates_submitted_application(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ])
            ->assertCreated()
            ->assertJsonPath('status', 'submitted');

        $this->assertDatabaseHas('saved_applications', [
            'user_id' => $user->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ]);

        $application = SavedApplication::first();
        $this->assertNotNull($application->status_updated_at);
    }

    public function test_apply_on_saved_scholarship_upgrades_same_record(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $saved = $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
        ])->assertCreated();

        $savedId = $saved->json('saved_application_id');

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ])
            ->assertOk()
            ->assertJsonPath('status', 'submitted')
            ->assertJsonPath('saved_application_id', $savedId);

        $this->assertDatabaseCount('saved_applications', 1);

        $this->assertNotNull(
            SavedApplication::first()->status_updated_at
        );
    }

    public function test_saving_same_scholarship_twice_does_not_create_duplicate(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
        ])->assertCreated();

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
        ])->assertStatus(409);

        $this->assertDatabaseCount('saved_applications', 1);
    }

    public function test_applying_twice_does_not_create_duplicate(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ])->assertCreated();

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ])->assertStatus(409);

        $this->assertDatabaseCount('saved_applications', 1);
    }

    public function test_save_after_apply_does_not_downgrade_status(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ])->assertCreated();

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'saved',
        ])->assertStatus(409);

        $this->assertDatabaseHas('saved_applications', [
            'user_id' => $user->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
        ]);
    }

    public function test_invalid_status_is_rejected(): void
    {
        $user = $this->createUser();
        $scholarship = $this->createScholarship();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'accepted',
        ])->assertStatus(422);

        $this->assertDatabaseCount('saved_applications', 0);
    }

    public function test_scholarship_id_must_exist(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $this->postJson('/api/saved-applications', [
            'scholarship_id' => 999999,
            'status' => 'submitted',
        ])->assertStatus(422);
    }

    public function test_index_returns_only_current_users_applications(): void
    {
        $owner = $this->createUser('owner@test.com');
        $other = $this->createUser('other@test.com');
        $scholarship = $this->createScholarship();

        SavedApplication::create([
            'user_id' => $owner->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'submitted',
            'saved_at' => now(),
        ]);

        SavedApplication::create([
            'user_id' => $other->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'saved',
            'saved_at' => now(),
        ]);

        Sanctum::actingAs($owner);

        $this->getJson('/api/saved-applications')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.user_id', $owner->user_id);
    }

    public function test_user_cannot_update_another_users_application(): void
    {
        $owner = $this->createUser('owner@test.com');
        $other = $this->createUser('other@test.com');
        $scholarship = $this->createScholarship();

        $application = SavedApplication::create([
            'user_id' => $owner->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'status' => 'saved',
            'saved_at' => now(),
        ]);

        Sanctum::actingAs($other);

        $this->patchJson(
            "/api/saved-applications/{$application->saved_application_id}/status",
            ['status' => 'submitted']
        )->assertForbidden();

        $this->assertDatabaseHas('saved_applications', [
            'saved_application_id' => $application->saved_application_id,
            'status' => 'saved',
        ]);
    }
}