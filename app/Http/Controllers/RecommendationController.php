<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
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
     * FR-09: triggers a fresh recommendation run for the authenticated
     * user, based on their StudentProfile + active Cv, against all
     * active scholarships. MatchingService handles scoring, mandatory
     * disqualification, and persisting both the recommendations and
     * their per-criterion breakdown (FR-10, FR-11) in one step.
     */
    public function generate(Request $request)
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();

        if (! $profile) {
            return response()->json([
                'message' => 'Please complete your profile before generating recommendations.',
            ], 422);
        }

        $recommendations = $this->matchingService->generate($request->user());

        // FR-09 alt scenario: no scholarships matched at all.
        if ($recommendations->isEmpty()) {
            return response()->json([
                'message' => 'No matching scholarships were found for your profile yet.',
                'count'   => 0,
                'data'    => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Recommendations generated successfully.',
            'count'   => $recommendations->count(),
            'data'    => $recommendations,
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