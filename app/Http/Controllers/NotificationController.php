<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * GET /api/notifications
     */
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $notifications = $query->orderByDesc('scheduled_for')->get();

        return response()->json($notifications);
    }

    /**
     * GET /api/notifications/{notification}
     */
    public function show(Notification $notification)
    {
        $this->authorizeOwner($notification);

        return response()->json($notification);
    }

    /**
     * DELETE /api/notifications/{notification}
     */
    public function destroy(Notification $notification)
    {
        $this->authorizeOwner($notification);

        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully.']);
    }

    private function authorizeOwner(Notification $notification): void
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this notification.');
        }
    }
}