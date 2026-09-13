<?php

namespace App\Http\Controllers;

use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * GET /api/admin/users
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->select([
                'user_id',
                'role',
                'full_name',
                'email',
                'is_active',
                'last_login_at',
                'created_at',
                'updated_at',
            ]);

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('is_active')) {
            $query->where(
                'is_active',
                $request->boolean('is_active')
            );
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return response()->json(
            $query->orderByDesc('created_at')->paginate(20)
        );
    }

    /**
     * GET /api/admin/users/{user}
     */
    public function show(User $user)
    {
        return response()->json(
            $user->load('studentProfile')
        );
    }

    /**
     * PATCH /api/admin/users/{user}/status
     */
    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        if ($user->user_id === Auth::id() &&
            $validated['is_active'] === false) {
            return response()->json([
                'message' => 'You cannot deactivate your own admin account.',
            ], 422);
        }

        $oldStatus = $user->is_active;

        $user->update([
            'is_active' => $validated['is_active'],
        ]);

        AdminActionLog::create([
            'admin_id' => Auth::id(),
            'action_type' => $validated['is_active']
                ? 'user_activated'
                : 'user_deactivated',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'details' => [
                'user_email' => $user->email,
                'old_status' => $oldStatus,
                'new_status' => $user->is_active,
            ],
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => $user->is_active
                ? 'User activated successfully.'
                : 'User deactivated successfully.',
            'user' => $user,
        ]);
    }

    /**
     * PATCH /api/admin/users/{user}/role
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:student,admin'],
        ]);

        if ($user->user_id === Auth::id() &&
            $validated['role'] !== 'admin') {
            return response()->json([
                'message' => 'You cannot remove your own admin role.',
            ], 422);
        }

        $oldRole = $user->role;

        $user->update([
            'role' => $validated['role'],
        ]);

        AdminActionLog::create([
            'admin_id' => Auth::id(),
            'action_type' => 'user_role_updated',
            'target_table' => 'users',
            'target_id' => $user->user_id,
            'details' => [
                'user_email' => $user->email,
                'old_role' => $oldRole,
                'new_role' => $user->role,
            ],
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'User role updated successfully.',
            'user' => $user,
        ]);
    }
}