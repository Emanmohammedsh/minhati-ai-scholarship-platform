<?php

namespace App\Http\Controllers;

use App\Models\AdminActionLog;
use App\Models\Scholarship;
use App\Models\ScholarshipCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipCriterionController extends Controller
{
    /**
     * GET /api/scholarships/{scholarship}/criteria
     */
    public function index(Scholarship $scholarship)
    {
        $criteria = $scholarship->criteria()->get();

        return response()->json($criteria);
    }

    /**
     * POST /api/scholarships/{scholarship}/criteria
     * Protected by 'admin' middleware at the route level
     */
    public function store(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'criterion_type'  => ['required', 'string', 'max:100'],
            'criterion_value' => ['required', 'string', 'max:255'],
            'weight'          => ['required', 'numeric', 'min:0', 'max:100'],
            'is_mandatory'    => ['sometimes', 'boolean'],
        ]);

        $validated['scholarship_id'] = $scholarship->scholarship_id;
        $validated['is_mandatory'] = $validated['is_mandatory'] ?? false;

        $criterion = ScholarshipCriterion::create($validated);

        $this->logAdminAction('scholarship_updated', $scholarship->scholarship_id, [
            'action'         => 'criterion_added',
            'criterion_id'   => $criterion->criterion_id,
            'criterion_type' => $criterion->criterion_type,
        ]);

        return response()->json($criterion, 201);
    }

    /**
     * PUT/PATCH /api/scholarships/{scholarship}/criteria/{criterion}
     * Protected by 'admin' middleware at the route level
     */
    public function update(Request $request, Scholarship $scholarship, ScholarshipCriterion $criterion)
    {
        $this->authorizeBelongsToScholarship($scholarship, $criterion);

        $validated = $request->validate([
            'criterion_type'  => ['sometimes', 'required', 'string', 'max:100'],
            'criterion_value' => ['sometimes', 'required', 'string', 'max:255'],
            'weight'          => ['sometimes', 'required', 'numeric', 'min:0', 'max:100'],
            'is_mandatory'    => ['sometimes', 'boolean'],
        ]);

        $criterion->update($validated);

        $this->logAdminAction('scholarship_updated', $scholarship->scholarship_id, [
            'action'         => 'criterion_updated',
            'criterion_id'   => $criterion->criterion_id,
            'changed_fields' => array_keys($validated),
        ]);

        return response()->json($criterion);
    }

    /**
     * DELETE /api/scholarships/{scholarship}/criteria/{criterion}
     * Protected by 'admin' middleware at the route level
     */
    public function destroy(Scholarship $scholarship, ScholarshipCriterion $criterion)
    {
        $this->authorizeBelongsToScholarship($scholarship, $criterion);

        $criterionId = $criterion->criterion_id;
        $criterion->delete();

        $this->logAdminAction('scholarship_updated', $scholarship->scholarship_id, [
            'action'       => 'criterion_removed',
            'criterion_id' => $criterionId,
        ]);

        return response()->json(['message' => 'Criterion deleted successfully.']);
    }

    /**
     * Confirms the criterion actually belongs to the scholarship in the URL (basic IDOR guard)
     */
    private function authorizeBelongsToScholarship(Scholarship $scholarship, ScholarshipCriterion $criterion): void
    {
        if ($criterion->scholarship_id !== $scholarship->scholarship_id) {
            abort(404, 'This criterion does not belong to the given scholarship.');
        }
    }

    private function logAdminAction(string $actionType, int $targetId, array $details = []): void
    {
        AdminActionLog::create([
            'admin_id'     => Auth::id(),
            'action_type'  => $actionType,
            'target_table' => 'scholarships',
            'target_id'    => $targetId,
            'details'      => $details,
        ]);
    }
} 