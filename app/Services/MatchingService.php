<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Recommendation;
use App\Models\RecommendationCriteriaMatch;
use App\Models\Scholarship;
use App\Models\ScholarshipCriterion;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Collection;

class MatchingService
{
    /**
     * FR-09 / FR-10 / FR-11: generate a ranked, scored recommendation
     * list for the given student, replacing any previous recommendations.
     */
    public function generate(User $user): Collection
    {
        $profile = StudentProfile::where('user_id', $user->user_id)->first();
        $cv = Cv::where('user_id', $user->user_id)->where('is_active', true)->first();

        // Recommendation-criteria-match rows cascade-delete via the FK,
        // so wiping old recommendations here is enough to regenerate clean.
        Recommendation::where('user_id', $user->user_id)->delete();

        $scholarships = Scholarship::where('is_active', true)
            ->with('criteria')
            ->get();

        $created = collect();

        foreach ($scholarships as $scholarship) {
            $result = $this->evaluate($scholarship, $profile, $cv);

            // FR-09: a scholarship that fails one of its mandatory
            // criteria is not a genuine match — excluded rather than
            // shown with a misleadingly low score.
            if ($result['disqualified'] || $result['score'] <= 0) {
                continue;
            }

            $recommendation = Recommendation::create([
                'user_id'        => $user->user_id,
                'scholarship_id' => $scholarship->scholarship_id,
                'cv_id'          => $cv?->cv_id,
                'match_score'    => $result['score'],
                'generated_at'   => now(),
            ]);

            foreach ($result['matches'] as $match) {
                RecommendationCriteriaMatch::create([
                    'recommendation_id'   => $recommendation->recommendation_id,
                    'criterion_id'        => $match['criterion_id'],
                    'is_satisfied'        => $match['satisfied'],
                    'contribution_points' => $match['points'],
                ]);
            }

            $created->push($recommendation->load('criteriaMatches'));
        }

        // FR-09: ranked list, highest score first.
        return $created->sortByDesc('match_score')->values();
    }

    /**
     * Scores one scholarship against the student's profile/CV data.
     *
     * @return array{score: float, disqualified: bool, matches: array}
     */
    private function evaluate(Scholarship $scholarship, ?StudentProfile $profile, ?Cv $cv): array
    {
        $criteria = $scholarship->criteria;

        if ($criteria->isEmpty()) {
            return ['score' => 0, 'disqualified' => false, 'matches' => []];
        }

        $totalWeight = 0.0;
        $earnedWeight = 0.0;
        $disqualified = false;
        $matches = [];

        foreach ($criteria as $criterion) {
            $satisfied = $this->criterionSatisfied($criterion, $profile, $cv);
            $weight = (float) $criterion->weight;
            $totalWeight += $weight;

            if ($satisfied) {
                $earnedWeight += $weight;
            } elseif ($criterion->is_mandatory) {
                // OBJ-03 / FR-09: an unmet mandatory criterion disqualifies
                // the scholarship entirely, regardless of other criteria.
                $disqualified = true;
            }

            $matches[] = [
                'criterion_id' => $criterion->criterion_id,
                'satisfied'    => $satisfied,
                'points'       => $satisfied ? $weight : 0,
            ];
        }

        $score = $totalWeight > 0
            ? round(($earnedWeight / $totalWeight) * 100, 2)
            : 0.0;

        return [
            'score'        => $score,
            'disqualified' => $disqualified,
            'matches'      => $matches,
        ];
    }

    /**
     * FR-11: checks a single criterion against the student's profile and
     * extracted CV data. Unknown criterion types fail closed — a type the
     * matcher doesn't recognize is never silently treated as satisfied.
     */
    private function criterionSatisfied(
        ScholarshipCriterion $criterion,
        ?StudentProfile $profile,
        ?Cv $cv
    ): bool {
        $value = mb_strtolower(trim($criterion->criterion_value));

        return match ($criterion->criterion_type) {
            'field_of_study' => $profile !== null
                && mb_strtolower(trim($profile->field_of_study ?? '')) === $value,

            'degree_level' => $profile !== null
                && mb_strtolower(trim($profile->degree_level ?? '')) === $value,

            'country' => $profile !== null
                && mb_strtolower(trim($profile->country ?? '')) === $value,

            'skill' => $cv !== null
                && $this->listContains($cv->extracted_skills, $value),

            'qualification' => $cv !== null
                && $this->listContains($cv->extracted_qualifications, $value),

            'education' => $cv !== null
                && $this->educationContains($cv->extracted_education, $value),

            default => false,
        };
    }

    private function listContains(?array $list, string $value): bool
    {
        if (empty($list)) {
            return false;
        }

        foreach ($list as $item) {
            if (mb_strtolower(trim((string) $item)) === $value) {
                return true;
            }
        }

        return false;
    }

    private function educationContains(?array $education, string $value): bool
    {
        if (empty($education)) {
            return false;
        }

        foreach ($education as $entry) {
            $degree = mb_strtolower(trim($entry['degree'] ?? ''));
            $institution = mb_strtolower(trim($entry['institution'] ?? ''));

            if ($degree === $value
                || $institution === $value
                || str_contains($degree, $value)
                || str_contains($institution, $value)
            ) {
                return true;
            }
        }

        return false;
    }
    
}