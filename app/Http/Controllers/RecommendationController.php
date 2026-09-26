<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\StudentProfile;
use App\Services\CourseRecommendationService;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function __construct(
        private MatchingService $matchingService,
        private CourseRecommendationService $courseRecommendationService
    ) {
    }

    /**
     * GET /api/recommendations
     * Returns previously generated recommendations
     * for the authenticated user.
     */
    public function index()
    {
        $recommendations = Recommendation::with([
            'scholarship',
            'cv',
        ])
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

        $recommendation->load([
            'scholarship.criteria',
            'cv',
            'criteriaMatches.criterion',
        ]);

        return response()->json($recommendation);
    }

    /**
     * POST /api/recommendations/generate
     *
     * Generates a fresh ranked recommendation list
     * for the authenticated student.
     */
    public function generate(Request $request)
    {
        $user = Auth::user();

        $profile = StudentProfile::where(
            'user_id',
            $user->user_id
        )->first();

        if (! $profile) {
            return response()->json([
                'message' => $this->isArabic()
                    ? 'يرجى إكمال ملفك الشخصي قبل إنشاء المطابقات.'
                    : 'Please complete your profile before generating recommendations.',
            ], 422);
        }

        $recommendations = $this->matchingService->generate($user);

        return response()->json([
            'message' => $this->isArabic()
                ? 'تم إنشاء مطابقات المنح بنجاح.'
                : 'Recommendations generated successfully.',
            'count' => $recommendations->count(),
            'data' => $recommendations,
        ], 201);
    }

    /**
     * GET /api/recommendations/{recommendation}/gap-analysis
     *
     * Provides an explainable breakdown of why the student
     * matched the scholarship and which requirements are missing.
     */
    public function gapAnalysis(Recommendation $recommendation)
    {
        $this->authorizeOwner($recommendation);

        $recommendation->load([
            'scholarship.criteria',
            'cv',
            'criteriaMatches.criterion',
        ]);

        $matchedCriteria = [];
        $gaps = [];

        foreach ($recommendation->criteriaMatches as $match) {
            $criterion = $match->criterion;

            if (! $criterion) {
                continue;
            }

            $item = [
                'criterion_id' => $criterion->criterion_id,
                'type' => $criterion->criterion_type,
                'required_value' => $criterion->criterion_value,
                'weight' => (float) $criterion->weight,
                'mandatory' => (bool) $criterion->is_mandatory,
                'contribution_points' => (float) $match->contribution_points,
            ];

            if ($match->is_satisfied) {
                $matchedCriteria[] = array_merge($item, [
                    'status' => 'matched',
                    'message' => $this->matchedMessage(
                        $criterion->criterion_type,
                        $criterion->criterion_value
                    ),
                ]);
            } else {
                $gaps[] = array_merge($item, [
                    'status' => 'missing',
                    'message' => $this->gapMessage(
                        $criterion->criterion_type,
                        $criterion->criterion_value
                    ),
                    'suggestion' => $this->gapSuggestion(
                        $criterion->criterion_type,
                        $criterion->criterion_value
                    ),
                    'course' => $this->courseSuggestionFor(
                        $criterion->criterion_type,
                        $criterion->criterion_value
                    ),
                ]);
            }
        }

        /*
         * Analysis warnings
         *
         * These warnings prevent a 100% match score from being
         * interpreted as complete application readiness.
         */
        $warnings = [];

        $criteriaCount = $recommendation->scholarship->criteria->count();

        if ($criteriaCount <= 1) {
            $warnings[] = [
                'type' => 'limited_criteria',
                'message' => $this->isArabic()
                    ? 'تحتوي هذه المنحة حاليًا على عدد محدود من معايير الأهلية في النظام، لذلك لا ينبغي اعتبار نسبة المطابقة دليلًا على الجاهزية الكاملة للتقديم.'
                    : 'This scholarship currently has limited eligibility criteria in the system. The match score should not be interpreted as full application readiness.',
            ];
        }

        if (! $recommendation->cv) {
            $warnings[] = [
                'type' => 'missing_cv',
                'message' => $this->isArabic()
                    ? 'لا توجد سيرة ذاتية نشطة مرتبطة بهذه المطابقة. ارفعي سيرة ذاتية أو فعّلي واحدة للحصول على تحليل أكثر اكتمالًا.'
                    : 'No active CV is connected to this recommendation. Upload or activate a CV for a more complete analysis.',
            ];
        }

        $mandatoryGaps = collect($gaps)
            ->where('mandatory', true)
            ->values()
            ->all();

        $optionalGaps = collect($gaps)
            ->where('mandatory', false)
            ->values()
            ->all();

        return response()->json([
            'recommendation_id' => $recommendation->recommendation_id,

            'scholarship' => [
                'scholarship_id' => $recommendation->scholarship->scholarship_id,
                'title' => $recommendation->scholarship->title,
                'provider_name' => $recommendation->scholarship->provider_name,
                'country' => $recommendation->scholarship->country,
            ],

            'match_score' => (float) $recommendation->match_score,

            'summary' => [
                'total_criteria' => $criteriaCount,
                'matched_criteria' => count($matchedCriteria),
                'missing_criteria' => count($gaps),
                'mandatory_gaps' => count($mandatoryGaps),
                'optional_gaps' => count($optionalGaps),
                'cv_connected' => $recommendation->cv !== null,
                'analysis_level' => $this->analysisLevel($criteriaCount),
            ],

            'matched_criteria' => $matchedCriteria,

            'gaps' => [
                'mandatory' => $mandatoryGaps,
                'optional' => $optionalGaps,
            ],

            'warnings' => $warnings,
        ]);
    }

    /**
     * DELETE /api/recommendations/{recommendation}
     */
    public function destroy(Recommendation $recommendation)
    {
        $this->authorizeOwner($recommendation);

        $recommendation->delete();

        return response()->json([
            'message' => $this->isArabic()
                ? 'تم حذف المطابقة بنجاح.'
                : 'Recommendation deleted successfully.',
        ]);
    }

    /**
     * Returns true when the current application language is Arabic.
     */
    private function isArabic(): bool
    {
        return app()->getLocale() === 'ar';
    }

    /**
     * Human-readable explanation for a satisfied criterion.
     */
    private function matchedMessage(string $type, string $value): string
    {
        if ($this->isArabic()) {
            return match ($type) {
                'country' =>
                    "بلدك يطابق البلد المطلوب: {$value}.",

                'degree_level' =>
                    "مستواك الدراسي يطابق المستوى المطلوب: {$value}.",

                'field_of_study' =>
                    "مجال دراستك يطابق متطلبات المنحة: {$value}.",

                'skill' =>
                    "سيرتك الذاتية تتضمن المهارة المطلوبة: {$value}.",

                'qualification' =>
                    "سيرتك الذاتية تتضمن المؤهل المطلوب: {$value}.",

                'education' =>
                    "بياناتك التعليمية تطابق متطلبات المنحة: {$value}.",

                default =>
                    'أنت تستوفي هذا الشرط من شروط المنحة.',
            };
        }

        return match ($type) {
            'country' =>
                "Your country matches the required country: {$value}.",

            'degree_level' =>
                "Your degree level matches the required level: {$value}.",

            'field_of_study' =>
                "Your field of study matches the scholarship requirement: {$value}.",

            'skill' =>
                "Your CV includes the required skill: {$value}.",

            'qualification' =>
                "Your CV includes the required qualification: {$value}.",

            'education' =>
                "Your education information matches the requirement: {$value}.",

            default =>
                'You satisfy this scholarship criterion.',
        };
    }

    /**
     * Human-readable explanation for an unmet criterion.
     */
    private function gapMessage(string $type, string $value): string
    {
        if ($this->isArabic()) {
            return match ($type) {
                'country' =>
                    "تتطلب المنحة أهلية مرتبطة بالدولة: {$value}.",

                'degree_level' =>
                    "لم تتم مطابقة المستوى الدراسي المطلوب: {$value}.",

                'field_of_study' =>
                    "لم تتم مطابقة مجال الدراسة المطلوب: {$value}.",

                'skill' =>
                    "لم يتم العثور على المهارة المطلوبة في سيرتك الذاتية النشطة: {$value}.",

                'qualification' =>
                    "لم يتم العثور على المؤهل المطلوب في سيرتك الذاتية النشطة: {$value}.",

                'education' =>
                    "لم يتم العثور على المعلومات التعليمية المطلوبة في سيرتك الذاتية النشطة: {$value}.",

                default =>
                    'لم يتم استيفاء هذا الشرط من شروط المنحة.',
            };
        }

        return match ($type) {
            'country' =>
                "The scholarship requires country eligibility for: {$value}.",

            'degree_level' =>
                "The required degree level was not matched: {$value}.",

            'field_of_study' =>
                "The required field of study was not matched: {$value}.",

            'skill' =>
                "The required skill was not found in your active CV: {$value}.",

            'qualification' =>
                "The required qualification was not found in your active CV: {$value}.",

            'education' =>
                "The required education information was not found in your active CV: {$value}.",

            default =>
                'This scholarship requirement has not been satisfied.',
        };
    }

    /**
     * Actionable suggestion for an unmet criterion.
     */
    private function gapSuggestion(string $type, string $value): string
    {
        if ($this->isArabic()) {
            return match ($type) {
                'country' =>
                    'راجعي شروط أهلية المنحة وتأكدي مما إذا كانت جنسيتك أو مكان إقامتك ضمن الفئات المقبولة.',

                'degree_level' =>
                    'تحققي مما إذا كان مستواك الدراسي الحالي أو المستهدف يطابق متطلبات المنحة.',

                'field_of_study' =>
                    'راجعي مجالات الدراسة المؤهلة وتأكدي من إدخال مجال دراستك بشكل صحيح في ملفك الشخصي.',

                'skill' =>
                    "إذا كانت لديك مهارة {$value}، أضيفيها بوضوح إلى سيرتك الذاتية حتى يتمكن النظام من اكتشافها.",

                'qualification' =>
                    "إذا كان لديك المؤهل {$value}، أضيفيه بوضوح إلى سيرتك الذاتية ثم ارفعي النسخة المحدثة.",

                'education' =>
                    'تأكدي من إدراج معلومات الدرجة العلمية والمؤسسة التعليمية بوضوح في سيرتك الذاتية.',

                default =>
                    'راجعي متطلبات المنحة وحدّثي ملفك الشخصي أو سيرتك الذاتية إذا كانت هناك معلومات ناقصة.',
            };
        }

        return match ($type) {
            'country' =>
                'Review the scholarship eligibility rules and confirm whether your residency or nationality is accepted.',

            'degree_level' =>
                'Check whether your current or intended degree level satisfies this scholarship requirement.',

            'field_of_study' =>
                'Review the eligible fields of study and make sure your profile contains the correct field.',

            'skill' =>
                "If you have {$value}, update your CV so the skill can be detected during CV analysis.",

            'qualification' =>
                "If you have {$value}, add the qualification clearly to your CV and upload the updated version.",

            'education' =>
                'Make sure your degree and institution information are clearly included in your CV.',

            default =>
                'Review the scholarship requirement and update your profile or CV if relevant information is missing.',
        };
    }

    /**
     * For skill/qualification gaps, ask Gemini for a real free course
     * that covers the missing item. Returns null if not a skill/qualification gap,
     * or if the AI service is unavailable.
     */
    private function courseSuggestionFor(string $type, string $value): ?array
    {
        if (! in_array($type, ['skill', 'qualification'])) {
            return null;
        }

        return $this->courseRecommendationService->suggestForSkill($value);
    }

    /**
     * Indicates how detailed/reliable the current gap analysis is,
     * based on the number of stored scholarship criteria.
     */
    private function analysisLevel(int $criteriaCount): string
    {
        if ($criteriaCount >= 4) {
            return 'detailed';
        }

        if ($criteriaCount >= 2) {
            return 'moderate';
        }

        return 'limited';
    }

    /**
     * Ensures that the authenticated user owns
     * the requested recommendation.
     */
    private function authorizeOwner(Recommendation $recommendation): void
    {
        if ($recommendation->user_id !== Auth::id()) {
            abort(
                403,
                $this->isArabic()
                    ? 'ليس لديك صلاحية للوصول إلى هذه المطابقة.'
                    : 'You do not have permission to access this recommendation.'
            );
        }
    }
}
