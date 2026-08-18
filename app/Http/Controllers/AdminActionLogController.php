<?php

namespace App\Http\Controllers;

use App\Models\AdminActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminActionLogController extends Controller
{
    /**
     * GET /api/admin/action-logs — admin only
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = AdminActionLog::with('admin');

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->input('action_type'));
        }

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->input('admin_id'));
        }

        $logs = $query->orderByDesc('created_at')->paginate(25);

        return response()->json($logs);
    }

    /**
     * GET /api/admin/action-logs/{adminActionLog} — admin only
     */
    public function show(AdminActionLog $adminActionLog)
    {
        $this->authorizeAdmin();

        return response()->json($adminActionLog->load('admin'));
    }

    private function authorizeAdmin(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'This action requires admin privileges.');
        }
    }
}