<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoverLetterController extends Controller
{
    /**
     * GET /api/cover-letters
     */
    public function index()
    {
        $letters = CoverLetter::with('scholarship')
            ->where('user_id', Auth::id())
            ->orderByDesc('requested_at')
            ->get();

        return response()->json($letters);
    }

    /**
     * GET /api/cover-letters/{coverLetter}
     */
    public function show(CoverLetter $coverLetter)
    {
        $this->authorizeOwner($coverLetter);

        return response()->json($coverLetter);
    }

    /**
     * POST /api/cover-letters
     * Kicks off AI generation of a cover letter for a given scholarship (FR-12)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scholarship_id' => ['required', 'integer', 'exists:scholarships,scholarship_id'],
        ]);

        $coverLetter = CoverLetter::create([
            'user_id'           => Auth::id(),
            'scholarship_id'    => $validated['scholarship_id'],
            'content'           => null,
            'generation_status' => 'pending',
            'requested_at'      => now(),
        ]);

        // TODO: dispatch a Job here to call the AI generation service and,
        // on completion, fill in content / generation_status / generation_time_ms / completed_at
        // GenerateCoverLetterJob::dispatch($coverLetter);

        return response()->json($coverLetter, 201);
    }

    /**
     * DELETE /api/cover-letters/{coverLetter}
     */
    public function destroy(CoverLetter $coverLetter)
    {
        $this->authorizeOwner($coverLetter);

        $coverLetter->delete();

        return response()->json(['message' => 'Cover letter deleted successfully.']);
    }

    private function authorizeOwner(CoverLetter $coverLetter): void
    {
        if ($coverLetter->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this cover letter.');
        }
    }
}