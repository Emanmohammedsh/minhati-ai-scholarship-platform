<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobRecommendation;
use App\Services\JobMatchingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobRecommendationController extends Controller
{
    public function __construct(
        private JobMatchingService $matchingService
    ) {
    }

    /**
     * Return the current user's job recommendations.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $recommendations = JobRecommendation::where(
            'user_id',
            $user->user_id
        )
            ->with([
                'job.requirements',
                'requirementMatches.requirement',
            ])
            ->orderByDesc('match_score')
            ->get();

        return response()->json([
            'count' => $recommendations->count(),
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Generate fresh job recommendations.
     */
    public function generate(Request $request): JsonResponse
    {
        $user = $request->user();

        $recommendations = $this->matchingService->generate($user);

        return response()->json([
            'message' => 'Job recommendations generated successfully.',
            'count' => $recommendations->count(),
            'recommendations' => $recommendations,
        ], 201);
    }

    /**
     * Explain why a job matched and identify missing requirements.
     */
    public function gapAnalysis(
        Request $request,
        JobRecommendation $recommendation
    ): JsonResponse {
        $user = $request->user();

        // A user may only inspect their own recommendation.
        if (
            (int) $recommendation->user_id
            !== (int) $user->user_id
        ) {
            abort(403);
        }

        $recommendation->load([
            'job.requirements',
            'requirementMatches.requirement',
            'cv',
        ]);

        $matched = [];
        $gaps = [];

        foreach ($recommendation->requirementMatches as $match) {
            $requirement = $match->requirement;

            if (!$requirement) {
                continue;
            }

            $item = [
                'requirement_id' => $requirement->requirement_id,
                'type' => $requirement->requirement_type,
                'value' => $requirement->required_value,
                'mandatory' => (bool) $requirement->is_mandatory,
                'weight' => (float) $requirement->weight,
                'contribution_points'
                    => (float) $match->contribution_points,
            ];

            if ($match->is_satisfied) {
                $matched[] = $item;
            } else {
                $gaps[] = $item;
            }
        }

        return response()->json([
            'job_recommendation_id'
                => $recommendation->job_recommendation_id,

            'job' => [
                'job_id' => $recommendation->job->job_id,
                'title' => $recommendation->job->title,
                'company_name'
                    => $recommendation->job->company_name,
            ],

            'match_score'
                => (float) $recommendation->match_score,

            'cv_connected'
                => $recommendation->cv !== null,

            'summary' => [
                'total_requirements'
                    => $recommendation->requirementMatches->count(),

                'matched_requirements'
                    => count($matched),

                'gaps'
                    => count($gaps),
            ],

            'matched_requirements' => $matched,

            'gaps' => $gaps,
        ]);
    }
}
