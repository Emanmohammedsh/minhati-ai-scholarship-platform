<?php

namespace App\Http\Controllers;

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
     * POST /api/scholarships/{scholarship}/criteria — admin only
     */
    public function store(Request $request, Scholarship $scholarship)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'criterion_type'  => ['required', 'string', 'max:100'],
            'criterion_value' => ['required', 'string', 'max:255'],
            'weight'          => ['required', 'numeric', 'min:0', 'max:100'],
            'is_mandatory'    => ['sometimes', 'boolean'],
        ]);

        $validated['scholarship_id'] = $scholarship->scholarship_id;
        $validated['is_mandatory'] = $validated['is_mandatory'] ?? false;

        $criterion = ScholarshipCriterion::create($validated);

        return response()->json($criterion, 201);
    }

    /**
     * PUT/PATCH /api/scholarships/{scholarship}/criteria/{criterion} — admin only
     */
    public function update(Request $request, Scholarship $scholarship, ScholarshipCriterion $criterion)
    {
        $this->authorizeAdmin();
        $this->authorizeBelongsToScholarship($scholarship, $criterion);

        $validated = $request->validate([
            'criterion_type'  => ['sometimes', 'required', 'string', 'max:100'],
            'criterion_value' => ['sometimes', 'required', 'string', 'max:255'],
            'weight'          => ['sometimes', 'required', 'numeric', 'min:0', 'max:100'],
            'is_mandatory'    => ['sometimes', 'boolean'],
        ]);

        $criterion->update($validated);

        return response()->json($criterion);
    }

    /**
     * DELETE /api/scholarships/{scholarship}/criteria/{criterion} — admin only
     */
    public function destroy(Scholarship $scholarship, ScholarshipCriterion $criterion)
    {
        $this->authorizeAdmin();
        $this->authorizeBelongsToScholarship($scholarship, $criterion);

        $criterion->delete();

        return response()->json(['message' => 'Criterion deleted successfully.']);
    }

    private function authorizeAdmin(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'This action requires admin privileges.');
        }
    }

    /**
     * Confirms the criterion actually belongs to the scholarship passed in the URL (basic IDOR guard)
     */
    private function authorizeBelongsToScholarship(Scholarship $scholarship, ScholarshipCriterion $criterion): void
    {
        if ($criterion->scholarship_id !== $scholarship->scholarship_id) {
            abort(404, 'This criterion does not belong to the given scholarship.');
        }
    }
}