<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use App\Models\Cv;
use App\Models\Scholarship;
use App\Models\StudentProfile;
use App\Services\CoverLetterGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        return response()->json(
            $coverLetter->load('scholarship')
        );
    }

    /**
     * POST /api/cover-letters
     */
    public function store(
        Request $request,
        CoverLetterGenerationService $generationService
    ) {
        $validated = $request->validate([
            'scholarship_id' => [
                'required',
                'integer',
                'exists:scholarships,scholarship_id',
            ],
        ]);

        $user = $request->user();

        $scholarship = Scholarship::findOrFail(
            $validated['scholarship_id']
        );

        $profile = StudentProfile::where(
            'user_id',
            $user->user_id
        )->first();

        $cv = Cv::where('user_id', $user->user_id)
            ->where('is_active', true)
            ->where('reviewed_by_student', true)
            ->first();

        $coverLetter = CoverLetter::create([
            'user_id' => $user->user_id,
            'scholarship_id' => $scholarship->scholarship_id,
            'content' => null,
            'generation_status' => 'processing',
            'requested_at' => now(),
        ]);

        $startTime = microtime(true);

        try {
            $content = $generationService->generate(
                $user,
                $scholarship,
                $profile,
                $cv
            );

            $generationTimeMs = (int) round(
                (microtime(true) - $startTime) * 1000
            );

            $coverLetter->update([
                'content' => $content,
                'generation_status' => 'completed',
                'generation_time_ms' => $generationTimeMs,
                'completed_at' => now(),
            ]);

            return response()->json(
                $coverLetter->fresh()->load('scholarship'),
                201
            );
        } catch (\Throwable $e) {
            $generationTimeMs = (int) round(
                (microtime(true) - $startTime) * 1000
            );

            $coverLetter->update([
                'generation_status' => 'failed',
                'generation_time_ms' => $generationTimeMs,
                'completed_at' => now(),
            ]);

            Log::error('Cover letter generation failed', [
                'cover_letter_id' => $coverLetter->cover_letter_id,
                'user_id' => $user->user_id,
                'scholarship_id' => $scholarship->scholarship_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Cover letter generation failed.',
                'cover_letter' => $coverLetter->fresh(),
            ], 502);
        }
    }

    /**
     * DELETE /api/cover-letters/{coverLetter}
     */
    public function destroy(CoverLetter $coverLetter)
    {
        $this->authorizeOwner($coverLetter);

        $coverLetter->delete();

        return response()->json([
            'message' => 'Cover letter deleted successfully.',
        ]);
    }

    private function authorizeOwner(
        CoverLetter $coverLetter
    ): void {
        if ($coverLetter->user_id !== Auth::id()) {
            abort(
                403,
                'You do not have permission to access this cover letter.'
            );
        }
    }
}
