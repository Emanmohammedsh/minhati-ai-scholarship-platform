<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    /**
     * GET /api/scholarships
     * List active scholarships, with simple filtering (country / field_of_study / degree_level)
     */
    public function index(Request $request)
    {
        $query = Scholarship::query()->where('is_active', true);

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('field_of_study')) {
            $query->where('field_of_study', $request->input('field_of_study'));
        }

        if ($request->filled('degree_level')) {
            $query->where('degree_level', $request->input('degree_level'));
        }

        $scholarships = $query
            ->orderBy('application_deadline', 'asc')
            ->paginate(15);

        return response()->json($scholarships);
    }

    /**
     * GET /api/scholarships/{scholarship}
     */
    public function show(Scholarship $scholarship)
    {
        $scholarship->load('criteria');

        return response()->json($scholarship);
    }

    /**
     * POST /api/scholarships — admin only
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'                 => ['required', 'string', 'max:255'],
            'provider_name'         => ['required', 'string', 'max:255'],
            'description'           => ['nullable', 'string'],
            'country'               => ['required', 'string', 'max:100'],
            'field_of_study'        => ['required', 'string', 'max:255'],
            'degree_level'          => ['required', 'string', 'max:100'],
            'application_deadline'  => ['required', 'date'],
            'external_link'         => ['required', 'url', 'max:500'],
            'is_active'             => ['sometimes', 'boolean'],
        ]);

        $validated['created_by_admin_id'] = Auth::id();
        $validated['is_active'] = $validated['is_active'] ?? true;

        $scholarship = Scholarship::create($validated);

        return response()->json($scholarship, 201);
    }

    /**
     * PUT/PATCH /api/scholarships/{scholarship} — admin only
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'                 => ['sometimes', 'required', 'string', 'max:255'],
            'provider_name'         => ['sometimes', 'required', 'string', 'max:255'],
            'description'           => ['nullable', 'string'],
            'country'               => ['sometimes', 'required', 'string', 'max:100'],
            'field_of_study'        => ['sometimes', 'required', 'string', 'max:255'],
            'degree_level'          => ['sometimes', 'required', 'string', 'max:100'],
            'application_deadline'  => ['sometimes', 'required', 'date'],
            'external_link'         => ['sometimes', 'required', 'url', 'max:500'],
            'is_active'             => ['sometimes', 'boolean'],
        ]);

        $scholarship->update($validated);

        return response()->json($scholarship);
    }

    /**
     * DELETE /api/scholarships/{scholarship} — admin only
     */
    public function destroy(Scholarship $scholarship)
    {
        $this->authorizeAdmin();

        $scholarship->delete();

        return response()->json(['message' => 'Scholarship deleted successfully.']);
    }

    /**
     * Simple admin check — temporary until you add a Policy/Middleware
     */
    private function authorizeAdmin(): void
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'This action requires admin privileges.');
        }
    }
}