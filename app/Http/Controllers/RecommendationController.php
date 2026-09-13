<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Recommendation;
use App\Models\RecommendationCriteriaMatch;
use App\Models\Scholarship;
use App\Models\StudentProfile;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $scholarships = Scholarship::where('is_active', true)->with('criteria')->get();

        $ranked = $this->matchingService->generateRecommendations($profile, $cv, $scholarships);

        $saved = DB::transaction(function () use ($ranked, $cv) {
            // Delete old recommendations AND their criteria matches together,
            // inside a transaction so a mid-run failure can't leave the user
            // with zero recommendations.
            $oldIds = Recommendation::where('user_id', Auth::id())->pluck('recommendation_id');
            RecommendationCriteriaMatch::whereIn('recommendation_id', $oldIds)->delete();
            Recommendation::where('user_id', Auth::id())->delete();

            $saved = [];

            foreach ($ranked as $result) {
                $recommendation = Recommendation::create([
                    'user_id'        => Auth::id(),
                    'scholarship_id' => $result['scholarship']->scholarship_id,
                    'cv_id'          => $cv?->cv_id,
                    'match_score'    => $result['score'],
                    'generated_at'   => now(),
                ]);

                // FR-11: persist which criteria contributed to this score so
                // the breakdown survives past this request (shown later via
                // show()'s criteriaMatches.criterion).
                foreach ($result['criteria_results'] as $criteriaResult) {
                    RecommendationCriteriaMatch::create([
                        'recommendation_id'   => $recommendation->recommendation_id,
                        'criterion_id'        => $criteriaResult['criterion']->criterion_id,
                        'is_satisfied'        => $criteriaResult['satisfied'],
                        'contribution_points' => $criteriaResult['satisfied'] ? $criteriaResult['criterion']->weight : 0,
                    ]);
                }

                $saved[] = $recommendation;
            }

            return $saved;
        });

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
