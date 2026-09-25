<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Scholarship;
use App\Models\ScholarshipCriterion;
use App\Models\StudentProfile;
use Illuminate\Support\Collection;
use App\Models\Recommendation;
use App\Models\RecommendationCriteriaMatch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class MatchingService
{
    /**
     * FR-09: rank scholarships against a student's profile + CV data.
     * FR-10: each result carries a 0-100 relevance score.
     * FR-11: each result carries which specific criteria matched.
     *
     * Returns a collection of:
     * ['scholarship' => Scholarship, 'score' => float,
     *  'criteria_results' => [['criterion' => ScholarshipCriterion, 'satisfied' => bool], ...]]
     * sorted by score descending. A scholarship is excluded entirely if
     * any is_mandatory criterion isn't satisfied, or if it scores 0
     * (US-01 acceptance criterion: "no matches found" rather than
     * showing 0% cards).
     */

    public function generate(User $user): Collection
{
    $profile = StudentProfile::where('user_id', $user->user_id)->first();

    if (! $profile) {
        return collect();
    }

    $cv = Cv::where('user_id', $user->user_id)
        ->where('is_active', true)
        ->where('reviewed_by_student', true)
        ->latest('cv_id')
        ->first();

    $scholarships = Scholarship::with('criteria')
        ->where('is_active', true)
        ->get();

    $results = $this->generateRecommendations(
        $profile,
        $cv,
        $scholarships
    );

    return DB::transaction(function () use ($user, $cv, $results) {

        // Refresh means replace the student's generated recommendations
        // with the newly calculated set.
        Recommendation::where('user_id', $user->user_id)->delete();

        $savedRecommendations = collect();

        foreach ($results as $result) {
            $scholarship = $result['scholarship'];

            $recommendation = Recommendation::create([
                'user_id' => $user->user_id,
                'scholarship_id' => $scholarship->scholarship_id,
                'cv_id' => $cv?->cv_id,
                'match_score' => $result['score'],
                'generated_at' => now(),
            ]);

            $totalWeight = (float) $scholarship->criteria->sum('weight');

            foreach ($result['criteria_results'] as $criterionResult) {
                $criterion = $criterionResult['criterion'];
                $satisfied = (bool) $criterionResult['satisfied'];

                $contributionPoints = 0;

                if ($satisfied && $totalWeight > 0) {
                    $contributionPoints = round(
                        ((float) $criterion->weight / $totalWeight) * 100,
                        2
                    );
                }

                RecommendationCriteriaMatch::create([
                    'recommendation_id' => $recommendation->recommendation_id,
                    'criterion_id' => $criterion->criterion_id,
                    'is_satisfied' => $satisfied,
                    'contribution_points' => $contributionPoints,
                ]);
            }

            $savedRecommendations->push(
                $recommendation->load([
                    'scholarship',
                    'cv',
                    'criteriaMatches.criterion',
                ])
            );
        }

        return $savedRecommendations;
    });
}
    public function generateRecommendations(StudentProfile $profile, ?Cv $cv, Collection $scholarships): Collection
    {
        return $scholarships
            ->map(fn (Scholarship $scholarship) => $this->scoreScholarship($scholarship, $profile, $cv))
            ->filter(fn ($result) => $result['score'] > 0)
            ->sortByDesc('score')
            ->values();
    }

    private function scoreScholarship(Scholarship $scholarship, StudentProfile $profile, ?Cv $cv): array
    {
        $criteria = $scholarship->criteria;

        if ($criteria->isEmpty()) {
            return ['scholarship' => $scholarship, 'score' => 0, 'criteria_results' => []];
        }

        $criteriaResults = $criteria->map(function (ScholarshipCriterion $criterion) use ($profile, $cv) {
            return [
                'criterion' => $criterion,
                'satisfied' => $this->isCriterionSatisfied($criterion, $profile, $cv),
            ];
        });

        $failedMandatory = $criteriaResults->contains(
            fn ($result) => $result['criterion']->is_mandatory && ! $result['satisfied']
        );

        if ($failedMandatory) {
            return ['scholarship' => $scholarship, 'score' => 0, 'criteria_results' => $criteriaResults->toArray()];
        }

        $totalWeight = $criteria->sum('weight');
        $earnedWeight = $criteriaResults
            ->filter(fn ($result) => $result['satisfied'])
            ->sum(fn ($result) => $result['criterion']->weight);

        $score = $totalWeight > 0
            ? round(($earnedWeight / $totalWeight) * 100, 2)
            : 0;

        return [
            'scholarship' => $scholarship,
            'score' => $score,
            'criteria_results' => $criteriaResults->toArray(),
        ];
    }

    private function isCriterionSatisfied(ScholarshipCriterion $criterion, StudentProfile $profile, ?Cv $cv): bool
    {
        $value = mb_strtolower(trim($criterion->criterion_value));

        return match (mb_strtolower($criterion->criterion_type)) {
            'field_of_study' => $this->fuzzyEquals($profile->field_of_study, $value),
            'degree_level' => $this->fuzzyEquals($profile->degree_level, $value),
            'country' => $this->fuzzyEquals($profile->country, $value),
            'skill' => $this->matchesSkillKeyword($value, $cv),
            default => $this->matchesSkillKeyword($value, $cv),
        };
    }

    private function fuzzyEquals(?string $studentValue, string $criterionValue): bool
    {
        if (! $studentValue) {
            return false;
        }

        return mb_strtolower(trim($studentValue)) === $criterionValue;
    }

    private function matchesSkillKeyword(string $keyword, ?Cv $cv): bool
    {
        if (! $cv || empty($cv->extracted_skills)) {
            return false;
        }

        foreach ($cv->extracted_skills as $skill) {
            if (str_contains(mb_strtolower($skill), $keyword)) {
                return true;
            }
        }

        return false;
    }
}
