<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOpportunity;
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
                'job.translations',
                'requirementMatches.requirement',
            ])
            ->orderByDesc('match_score')
            ->get();

        return response()->json([
            'count' => $recommendations->count(),

            'recommendations' => $recommendations
                ->map(
                    fn ($recommendation) =>
                        $this->localizeRecommendation($recommendation)
                ),
        ]);
    }

    /**
     * Generate fresh job recommendations.
     */
    public function generate(Request $request): JsonResponse
    {
        $user = $request->user();

        // Generate recommendations using the existing matching engine.
        $recommendations = $this->matchingService->generate($user);

        /*
         * Load job details and translations after matching.
         * Works with both Eloquent and regular Laravel collections.
         */
        foreach ($recommendations as $recommendation) {
            $recommendation->load([
                'job.requirements',
                'job.translations',
                'requirementMatches.requirement',
            ]);
        }

        return response()->json([
            'message' => app()->getLocale() === 'ar'
                ? 'تم إنشاء توصيات الوظائف بنجاح.'
                : 'Job recommendations generated successfully.',

            'count' => $recommendations->count(),

            'recommendations' => $recommendations
                ->map(
                    fn ($recommendation) =>
                        $this->localizeRecommendation($recommendation)
                ),
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
            'job.translations',
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
                'contribution_points' =>
                    (float) $match->contribution_points,
            ];

            if ($match->is_satisfied) {
                $matched[] = $item;
            } else {
                $gaps[] = $item;
            }
        }

        $job = $recommendation->job;

        return response()->json([
            'job_recommendation_id' =>
                $recommendation->job_recommendation_id,

            'job' => [
                'job_id' => $job->job_id,

                'title' => $this->localizedJobField(
                    $job,
                    'title'
                ),

                // Company names remain unchanged.
                'company_name' => $job->company_name,
            ],

            'match_score' =>
                (float) $recommendation->match_score,

            'cv_connected' =>
                $recommendation->cv !== null,

            'summary' => [
                'total_requirements' =>
                    $recommendation->requirementMatches->count(),

                'matched_requirements' =>
                    count($matched),

                'gaps' =>
                    count($gaps),
            ],

            'matched_requirements' => $matched,

            'gaps' => $gaps,
        ]);
    }

    /**
     * Localize the job data returned by the API
     * without modifying canonical matching data.
     */
    private function localizeRecommendation(
        JobRecommendation $recommendation
    ): array {
        $data = $recommendation->toArray();

        $job = $recommendation->job;

        if (!$job) {
            return $data;
        }

        $data['job']['title'] = $this->localizedJobField(
            $job,
            'title'
        );

        $data['job']['description'] = $this->localizedJobField(
            $job,
            'description'
        );

        // Return only the selected language's content.
        unset($data['job']['translations']);

        return $data;
    }

    /**
     * Get the requested translation.
     * Fall back to the original job data if unavailable.
     */
    private function localizedJobField(
        JobOpportunity $job,
        string $field
    ): ?string {
        $locale = app()->getLocale();

        $translation = $job->translations
            ->firstWhere('locale', $locale);

        $value = $translation?->{$field};

        if ($value !== null && trim($value) !== '') {
            return $value;
        }

        return $job->{$field};
    }
}
