<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOpportunity;
use App\Models\JobRequirement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminJobRequirementController extends Controller
{
    /**
     * List all requirements for one job.
     */
    public function index(JobOpportunity $job)
    {
        $requirements = $job->requirements()
            ->orderBy('requirement_id')
            ->get();

        return response()->json([
            'job_id' => $job->job_id,
            'count' => $requirements->count(),
            'requirements' => $requirements,
        ]);
    }

    /**
     * Add a requirement to a job.
     */
    public function store(
        Request $request,
        JobOpportunity $job
    ) {
        $validated = $request->validate([
            'requirement_type' => [
                'required',
                'string',
                Rule::in([
                    'field_of_study',
                    'degree_level',
                    'country',
                    'skill',
                    'qualification',
                    'education',
                    'experience',
                    'language',
                ]),
            ],

            'required_value' => [
                'required',
                'string',
                'max:255',
            ],

            'is_mandatory' => [
                'sometimes',
                'boolean',
            ],

            'weight' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        $requirement = $job->requirements()->create([
            'requirement_type'
                => $validated['requirement_type'],

            'required_value'
                => $validated['required_value'],

            'is_mandatory'
                => $validated['is_mandatory'] ?? false,

            'weight'
                => $validated['weight'],
        ]);

        return response()->json([
            'message' => 'Job requirement created successfully.',
            'requirement' => $requirement,
        ], 201);
    }

    /**
     * Show one requirement belonging to the job.
     */
    public function show(
        JobOpportunity $job,
        JobRequirement $requirement
    ) {
        $this->ensureRequirementBelongsToJob(
            $job,
            $requirement
        );

        return response()->json([
            'requirement' => $requirement,
        ]);
    }

    /**
     * Update a requirement.
     */
    public function update(
        Request $request,
        JobOpportunity $job,
        JobRequirement $requirement
    ) {
        $this->ensureRequirementBelongsToJob(
            $job,
            $requirement
        );

        $validated = $request->validate([
            'requirement_type' => [
                'sometimes',
                'required',
                'string',
                Rule::in([
                    'field_of_study',
                    'degree_level',
                    'country',
                    'skill',
                    'qualification',
                    'education',
                    'experience',
                    'language',
                ]),
            ],

            'required_value' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'is_mandatory' => [
                'sometimes',
                'boolean',
            ],

            'weight' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        $requirement->update($validated);

        return response()->json([
            'message' => 'Job requirement updated successfully.',
            'requirement' => $requirement->fresh(),
        ]);
    }

    /**
     * Delete a requirement.
     */
    public function destroy(
        JobOpportunity $job,
        JobRequirement $requirement
    ) {
        $this->ensureRequirementBelongsToJob(
            $job,
            $requirement
        );

        $requirement->delete();

        return response()->json([
            'message' => 'Job requirement deleted successfully.',
        ]);
    }

    /**
     * Prevent accessing a requirement through the wrong job.
     */
    private function ensureRequirementBelongsToJob(
        JobOpportunity $job,
        JobRequirement $requirement
    ): void {
        if (
            (int) $requirement->job_id
            !== (int) $job->job_id
        ) {
            abort(
                404,
                'Job requirement not found for this job.'
            );
        }
    }
}
