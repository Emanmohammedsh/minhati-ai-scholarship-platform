<?php

namespace App\Http\Controllers;

use App\Models\SavedApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SavedApplicationController extends Controller
{
    private const STATUSES = ['saved', 'submitted', 'under_review'];

    /**
     * GET /api/saved-applications
     */
    public function index(Request $request)
    {
        $query = SavedApplication::with('scholarship')
            ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $saved = $query->orderByDesc('saved_at')->get();

        return response()->json($saved);
    }

    /**
     * POST /api/saved-applications
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scholarship_id' => ['required', 'integer', 'exists:scholarships,scholarship_id'],
            'status'         => ['sometimes', Rule::in(self::STATUSES)],
        ]);

        $existing = SavedApplication::where('user_id', Auth::id())
            ->where('scholarship_id', $validated['scholarship_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'This scholarship is already saved.',
                'data'    => $existing,
            ], 409);
        }

        $saved = SavedApplication::create([
            'user_id'        => Auth::id(),
            'scholarship_id' => $validated['scholarship_id'],
            'status'         => $validated['status'] ?? 'saved',
            'saved_at'       => now(),
        ]);

        return response()->json($saved, 201);
    }

    /**
     * PATCH /api/saved-applications/{savedApplication}/status
     */
    public function updateStatus(Request $request, SavedApplication $savedApplication)
    {
        $this->authorizeOwner($savedApplication);

        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $savedApplication->update([
            'status'             => $validated['status'],
            'status_updated_at'  => now(),
        ]);

        return response()->json($savedApplication);
    }

    /**
     * DELETE /api/saved-applications/{savedApplication}
     */
    public function destroy(SavedApplication $savedApplication)
    {
        $this->authorizeOwner($savedApplication);

        $savedApplication->delete();

        return response()->json(['message' => 'Saved application removed successfully.']);
    }

    private function authorizeOwner(SavedApplication $savedApplication): void
    {
        if ($savedApplication->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this saved application.');
        }
    }
}