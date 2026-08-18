<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    /**
     * GET /api/student-profile
     * Returns the authenticated user's profile
     */
    public function show()
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();

        if (! $profile) {
            return response()->json([
                'message' => 'No profile found. Please create one first.',
            ], 404);
        }

        return response()->json($profile);
    }

    /**
     * POST /api/student-profile
     * Creates a new profile for the authenticated user (if none exists yet)
     */
    public function store(Request $request)
    {
        $existing = StudentProfile::where('user_id', Auth::id())->first();
        if ($existing) {
            return response()->json([
                'message' => 'A profile already exists for this user. Use update instead.',
            ], 409);
        }

        $validated = $request->validate([
            'academic_background' => ['nullable', 'string'],
            'field_of_study'      => ['required', 'string', 'max:255'],
            'degree_level'        => ['required', 'string', 'max:100'],
            'interests'           => ['nullable', 'string'],
            'country'             => ['required', 'string', 'max:100'],
        ]);

        $validated['user_id'] = Auth::id();

        $profile = StudentProfile::create($validated);

        return response()->json($profile, 201);
    }

    /**
     * PUT/PATCH /api/student-profile
     */
    public function update(Request $request)
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();

        if (! $profile) {
            return response()->json([
                'message' => 'No profile found to update. Please create one first.',
            ], 404);
        }

        $validated = $request->validate([
            'academic_background' => ['nullable', 'string'],
            'field_of_study'      => ['sometimes', 'required', 'string', 'max:255'],
            'degree_level'        => ['sometimes', 'required', 'string', 'max:100'],
            'interests'           => ['nullable', 'string'],
            'country'             => ['sometimes', 'required', 'string', 'max:100'],
        ]);

        $profile->update($validated);

        return response()->json($profile);
    }

    /**
     * DELETE /api/student-profile
     */
    public function destroy()
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();

        if (! $profile) {
            return response()->json(['message' => 'No profile found to delete.'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully.']);
    }
}