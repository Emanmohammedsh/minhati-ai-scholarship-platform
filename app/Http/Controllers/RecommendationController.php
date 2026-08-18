<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Recommendation;
use App\Models\Scholarship;
use App\Models\StudentProfile;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function __construct(private MatchingService $matchingService)
    {
    }

    /**
     * GET /api/recommendations
     * Returns previously generated recommendations for the authenticated user
     */
    public function index()
    {
        $recommendations = Recommendation::with(['scholarship', 'cv'])
            ->where('user_id', Auth::id())
            ->orderByDesc('match_score')
            ->get();

        return response()->json($recommendations);
    }

    /**
     * GET /api/recommendations/{recommendation}
     */
    public function show(Recommendation $recommendation)
    {
        $this->authorizeOwner($recommendation);

        $recommendation->load(['scholarship.criteria', 'cv', 'criteriaMatches.criterion']);

        return response()->json($recommendation);
    }

    /**
     * POST /api/recommendations/generate
     * Triggers a fresh recommendation run for the authenticated user,
     * based on their StudentProfile + active Cv, against all active scholarships.
     */
    public function generate(Request $request)
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();

        if (! $profile) {
            return response()->json([
                'message' => 'Please complete your profile before generating recommendations.',
            ], 422);
        }

        $cv = Cv::where('user_id', Auth::id())
            ->where('is_active', true)
            ->first();

        $scholarships = Scholarship::where('is_active', true)->get();

        $ranked = $this->matchingService->generateRecommendations($profile, $cv, $scholarships);

        $saved = [];

        foreach ($ranked as $result) {
            $saved[] = Recommendation::create([
                'user_id'        => Auth::id(),
                'scholarship_id' => $result['scholarship']->scholarship_id,
                'cv_id'          => $cv?->cv_id,
                'match_score'    => $result['score'],
                'generated_at'   => now(),
            ]);
        }

        return response()->json([
            'message' => 'Recommendations generated successfully.',
            'count'   => count($saved),
            'data'    => $saved,
        ], 201);
    }

    /**
     * DELETE /api/recommendations/{recommendation}
     */
    public function destroy(Recommendation $recommendation)
    {
        $this->authorizeOwner($recommendation);

        $recommendation->delete();

        return response()->json(['message' => 'Recommendation deleted successfully.']);
    }

    private function authorizeOwner(Recommendation $recommendation): void
    {
        if ($recommendation->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this recommendation.');
        }
    }
}