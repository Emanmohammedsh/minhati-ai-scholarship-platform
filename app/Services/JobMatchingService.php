<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\JobOpportunity;
use App\Models\JobRecommendation;
use App\Models\JobRequirement;
use App\Models\JobRequirementMatch;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class JobMatchingService
{
    /**
     * Generate ranked job recommendations for the user.
     * Previous job recommendations are replaced safely.
     */
    public function generate(User $user): Collection
    {
        $profile = StudentProfile::where(
            'user_id',
            $user->user_id
        )->first();

        $cv = Cv::where(
            'user_id',
            $user->user_id
        )
            ->where('is_active', true)
            ->first();

        return DB::transaction(function () use ($user, $profile, $cv) {

            // job_requirement_matches cascade-delete through the FK.
            JobRecommendation::where(
                'user_id',
                $user->user_id
            )->delete();

            $jobs = JobOpportunity::where(
                'is_active',
                true
            )
                ->with('requirements')
                ->get();

            $created = collect();

            foreach ($jobs as $job) {

                $result = $this->evaluate(
                    $job,
                    $profile,
                    $cv
                );

                /*
                 * Same principle as scholarship matching:
                 * an unmet mandatory requirement disqualifies the job.
                 */
                if (
                    $result['disqualified'] ||
                    $result['score'] <= 0
                ) {
                    continue;
                }

                $recommendation = JobRecommendation::create([
                    'user_id'      => $user->user_id,
                    'job_id'       => $job->job_id,
                    'cv_id'        => $cv?->cv_id,
                    'match_score'  => $result['score'],
                    'generated_at' => now(),
                ]);

                foreach ($result['matches'] as $match) {

                    JobRequirementMatch::create([
                        'job_recommendation_id'
                            => $recommendation->job_recommendation_id,

                        'requirement_id'
                            => $match['requirement_id'],

                        'is_satisfied'
                            => $match['satisfied'],

                        'contribution_points'
                            => $match['points'],
                    ]);
                }

                $created->push(
                    $recommendation->load([
                        'job',
                        'requirementMatches.requirement',
                    ])
                );
            }

            return $created
                ->sortByDesc('match_score')
                ->values();
        });
    }

    /**
     * Evaluate one job against the user's profile and CV.
     *
     * @return array{
     *     score: float,
     *     disqualified: bool,
     *     matches: array
     * }
     */
    private function evaluate(
        JobOpportunity $job,
        ?StudentProfile $profile,
        ?Cv $cv
    ): array {
        $requirements = $job->requirements;

        if ($requirements->isEmpty()) {
            return [
                'score' => 0,
                'disqualified' => false,
                'matches' => [],
            ];
        }

        $totalWeight = 0.0;
        $earnedWeight = 0.0;
        $disqualified = false;
        $matches = [];

        foreach ($requirements as $requirement) {

            $satisfied = $this->requirementSatisfied(
                $requirement,
                $profile,
                $cv
            );

            $weight = (float) $requirement->weight;

            $totalWeight += $weight;

            if ($satisfied) {

                $earnedWeight += $weight;

            } elseif ($requirement->is_mandatory) {

                $disqualified = true;
            }

            $matches[] = [
                'requirement_id'
                    => $requirement->requirement_id,

                'satisfied'
                    => $satisfied,

                'points'
                    => $satisfied ? $weight : 0,
            ];
        }

        $score = $totalWeight > 0
            ? round(
                ($earnedWeight / $totalWeight) * 100,
                2
            )
            : 0.0;

        return [
            'score' => $score,
            'disqualified' => $disqualified,
            'matches' => $matches,
        ];
    }

    /**
     * Check one job requirement against real profile/CV data.
     *
     * Unknown or unsupported requirement types fail closed.
     */
    private function requirementSatisfied(
        JobRequirement $requirement,
        ?StudentProfile $profile,
        ?Cv $cv
    ): bool {
        $value = mb_strtolower(
            trim($requirement->required_value)
        );

        return match ($requirement->requirement_type) {

            'field_of_study' =>
                $profile !== null
                && $this->textMatches(
                    $profile->field_of_study ?? '',
                    $value
                ),

            'degree_level' =>
                $profile !== null
                && $this->textMatches(
                    $profile->degree_level ?? '',
                    $value
                ),

            'country' =>
                $profile !== null
                && $this->textMatches(
                    $profile->country ?? '',
                    $value
                ),

            'skill' =>
                $cv !== null
                && $this->listContains(
                    $cv->extracted_skills,
                    $value
                ),

            'qualification' =>
                $cv !== null
                && $this->listContains(
                    $cv->extracted_qualifications,
                    $value
                ),

            'education' =>
                $cv !== null
                && $this->educationContains(
                    $cv->extracted_education,
                    $value
                ),

            /*
             * These types remain unsupported until the project
             * has reliable structured data for them.
             * We never silently assume that they are satisfied.
             */
            'experience' => false,

            'language' => false,

            default => false,
        };
    }

    /**
     * Compare simple profile text.
     */
    private function textMatches(
        ?string $actual,
        string $required
    ): bool {
        $actual = mb_strtolower(
            trim($actual ?? '')
        );

        if ($actual === '') {
            return false;
        }

        return $actual === $required
            || str_contains($actual, $required)
            || str_contains($required, $actual);
    }

    /**
     * Search extracted CV list fields such as
     * skills and qualifications.
     */
    private function listContains(
        ?array $list,
        string $value
    ): bool {
        if (empty($list)) {
            return false;
        }

        foreach ($list as $item) {

            $normalized = mb_strtolower(
                trim((string) $item)
            );

            if (
                $normalized === $value
                || str_contains($normalized, $value)
                || str_contains($value, $normalized)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Search structured education extracted from the CV.
     */
    private function educationContains(
        ?array $education,
        string $value
    ): bool {
        if (empty($education)) {
            return false;
        }

        foreach ($education as $entry) {

            if (!is_array($entry)) {
                continue;
            }

            $degree = mb_strtolower(
                trim($entry['degree'] ?? '')
            );

            $institution = mb_strtolower(
                trim($entry['institution'] ?? '')
            );

            if (
                $degree === $value
                || $institution === $value
                || (
                    $degree !== ''
                    && str_contains($degree, $value)
                )
                || (
                    $institution !== ''
                    && str_contains($institution, $value)
                )
            ) {
                return true;
            }
        }

        return false;
    }
}
