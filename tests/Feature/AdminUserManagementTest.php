<?php

namespace Tests\Feature;

use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users(): void
    {
        $admin = User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@test.com',
            'password_hash' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'full_name' => 'Student User',
            'email' => 'student@test.com',
            'password_hash' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/admin/users');

        $response->assertOk()
            ->assertJsonPath('total', 2);
    }

    public function test_admin_can_deactivate_user_and_action_is_logged(): void
    {
        $admin = User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@test.com',
            'password_hash' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::create([
            'full_name' => 'Student User',
            'email' => 'student@test.com',
            'password_hash' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->patchJson("/api/admin/users/{$student->user_id}/status", [
                'is_active' => false,
            ]);

        $response->assertOk()
            ->assertJsonPath('message', 'User deactivated successfully.');

        $this->assertDatabaseHas('users', [
            'user_id' => $student->user_id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('admin_action_logs', [
            'admin_id' => $admin->user_id,
            'action_type' => 'user_deactivated',
            'target_table' => 'users',
            'target_id' => $student->user_id,
        ]);
    }

    public function test_student_cannot_access_admin_users(): void
    {
        $student = User::create([
            'full_name' => 'Student User',
            'email' => 'student@test.com',
            'password_hash' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($student, 'sanctum')
            ->getJson('/api/admin/users');

        $response->assertStatus(403);
    }
}
