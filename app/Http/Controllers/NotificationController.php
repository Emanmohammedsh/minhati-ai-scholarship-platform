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
        $query = Notification::with('savedApplication.scholarship')
            ->where('user_id', Auth::id());

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

        return response()->json($notification->load('savedApplication.scholarship'));
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

    /**
     * GET /api/notifications/unread-count
     */
    public function unreadCount(Request $request)
    {
        $count = Notification::forUser(Auth::id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * POST /api/notifications/{notification}/read
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorizeOwner($notification);

        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * POST /api/notifications/read-all
     */
    public function markAllAsRead(Request $request)
    {
        Notification::forUser(Auth::id())
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    private function authorizeOwner(Notification $notification): void
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this notification.');
        }
    }
}