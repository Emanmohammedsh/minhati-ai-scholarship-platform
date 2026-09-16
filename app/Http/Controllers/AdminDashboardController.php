<?php

namespace App\Http\Controllers;

use App\Models\AdminActionLog;
use App\Models\Recommendation;
use App\Models\SavedApplication;
use App\Models\Scholarship;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * GET /api/admin/dashboard-stats
     */
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),

            'active_students' => User::where('role', 'student')
                ->where('is_active', true)
                ->count(),

            'admins' => User::where('role', 'admin')
                ->count(),

            'active_scholarships' => Scholarship::where(
                'is_active',
                true
            )->count(),

            'recommendations' => Recommendation::count(),

            'saved_applications' => SavedApplication::count(),

            'recent_users' => User::select([
                    'user_id',
                    'full_name',
                    'email',
                    'role',
                    'is_active',
                    'created_at',
                ])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),

            'recent_admin_actions' => AdminActionLog::with('admin')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
