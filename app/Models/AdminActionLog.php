<?php

namespace App\Http\Controllers;

use App\Models\AdminActionLog;
use Illuminate\Http\Request;

class AdminActionLogController extends Controller
{
    /**
     * GET /api/admin/action-logs
     * Protected by 'admin' middleware at the route level
     */
    public function index(Request $request)
    {
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
     * GET /api/admin/action-logs/{adminActionLog}
     * Protected by 'admin' middleware at the route level
     */
    public function show(AdminActionLog $adminActionLog)
    {
        return response()->json($adminActionLog->load('admin'));
    }
}