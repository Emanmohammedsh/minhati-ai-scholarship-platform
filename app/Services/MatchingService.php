<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Scholarship;
use App\Models\ScholarshipCriterion;
use App\Models\StudentProfile;
use Illuminate\Support\Collection;

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
