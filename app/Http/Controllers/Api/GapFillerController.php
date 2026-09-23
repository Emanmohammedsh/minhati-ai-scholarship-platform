<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobRecommendation;
use App\Services\CourseRecommendationService;
use App\Services\GapFillerService;
use Illuminate\Http\Request;

class GapFillerController extends Controller
{
    public function generate(
        Request $request,
        JobRecommendation $recommendation,
        GapFillerService $gapFillerService,
        CourseRecommendationService $courseRecommendationService
    ) {
        /*
         * Security:
         * A user can only generate a plan for
         * their own recommendation.
         */
        if (
            (int) $recommendation->user_id
            !== (int) $request->user()->user_id
        ) {
            abort(403, 'Forbidden.');
        }

        $validated = $request->validate([
            'requirement_id' => [
                'required',
                'integer',
            ],
        ]);

        /*
         * Load the real matching data.
         */
        $recommendation->load([
            'job.requirements',
            'requirementMatches.requirement',
            'cv',
        ]);

        /*
         * Find the requested requirement inside
         * this recommendation only.
         */
        $match = $recommendation
            ->requirementMatches
            ->first(function ($item) use ($validated) {
                return
                    (int) $item->requirement_id
                    === (int) $validated['requirement_id'];
            });

        if (! $match || ! $match->requirement) {
            return response()->json([
                'message' =>
                    'Requirement does not belong to this recommendation.',
            ], 404);
        }

        /*
         * Gap Filler must work ONLY on an
         * unsatisfied requirement.
         */
        if ($match->is_satisfied) {
            return response()->json([
                'message' =>
                    'This requirement is already satisfied.',
            ], 422);
        }

        $requirement = $match->requirement;

        /*
         * Use only verified skills extracted
         * from the active CV connected to
         * this recommendation.
         */
        $currentSkills = [];

        if ($recommendation->cv) {
            $skills =
                $recommendation->cv->extracted_skills
                ?? [];

            if (is_array($skills)) {
                $currentSkills = array_values(
                    array_filter(
                        $skills,
                        fn ($skill) =>
                            is_string($skill)
                            && trim($skill) !== ''
                    )
                );
            }
        }

        /*
         * Gemini explains the already verified gap.
         * It does NOT decide the match result.
         */
        $plan = $gapFillerService->generatePlan(
            $recommendation->job->title,
            $requirement->requirement_type,
            $requirement->required_value,
            $currentSkills
        );

        /*
         * Suggest a learning resource for the
         * already verified missing requirement.
         *
         * This does NOT change the real match score.
         */
        $recommendedCourse =
            $courseRecommendationService->suggestForSkill(
                $requirement->required_value
            );

        /*
         * Calculate the potential match score
         * if this specific verified gap were
         * satisfied.
         *
         * This follows the same weighted scoring
         * principle used by JobMatchingService:
         *
         * earned weight / total weight * 100
         *
         * Gemini is NOT involved in this calculation.
         */
        $totalWeight = (float) $recommendation
            ->job
            ->requirements
            ->sum(function ($item) {
                return (float) $item->weight;
            });

        /*
         * Sum only the contribution points already
         * earned in the persisted matching result.
         */
        $currentEarnedWeight = (float) $recommendation
            ->requirementMatches
            ->sum(function ($item) {
                return (float) $item->contribution_points;
            });

        /*
         * The selected requirement is already
         * verified as unsatisfied above, so its
         * current contribution is zero.
         *
         * Simulate satisfying this one requirement
         * by adding its configured weight.
         */
        $potentialEarnedWeight =
            $currentEarnedWeight
            + (float) $requirement->weight;

        /*
         * Calculate the hypothetical score and
         * never allow it to exceed 100%.
         */
        $potentialMatchScore =
            $totalWeight > 0
                ? round(
                    min(
                        100,
                        (
                            $potentialEarnedWeight
                            / $totalWeight
                        ) * 100
                    ),
                    2
                )
                : (float) $recommendation->match_score;

        return response()->json([
            'recommendation_id' =>
                $recommendation->job_recommendation_id,

            'job' => [
                'job_id' =>
                    $recommendation->job->job_id,

                'title' =>
                    $recommendation->job->title,

                'company_name' =>
                    $recommendation->job->company_name,
            ],

            /*
             * Actual persisted match score.
             */
            'current_match_score' =>
                (float) $recommendation->match_score,

            /*
             * Hypothetical deterministic score if
             * this one missing requirement becomes
             * satisfied.
             */
            'potential_match_score' =>
                $potentialMatchScore,

            'potential_score_note' =>
                'Estimated score if this specific gap becomes satisfied.',

            'gap' => [
                'requirement_id' =>
                    $requirement->requirement_id,

                'type' =>
                    $requirement->requirement_type,

                'required_value' =>
                    $requirement->required_value,

                'is_mandatory' =>
                    (bool) $requirement->is_mandatory,

                'weight' =>
                    (float) $requirement->weight,
            ],

            /*
             * AI-generated explanation and
             * personalized learning steps.
             */
            'learning_plan' =>
                $plan,

            /*
             * Suggested learning resource.
             */
            'recommended_course' =>
                $recommendedCourse,
        ]);
    }
}
