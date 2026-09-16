<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOpportunity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminJobController extends Controller
{
    /**
     * List all jobs for admin.
     */
    public function index()
    {
        $jobs = JobOpportunity::with('requirements')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'count' => $jobs->count(),
            'jobs' => $jobs,
        ]);
    }

    /**
     * Show one job.
     */
    public function show(JobOpportunity $job)
    {
        return response()->json([
            'job' => $job->load('requirements'),
        ]);
    }

    /**
     * Create a new job.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'company_name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'country' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'employment_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'work_mode' => [
                'nullable',
                'string',
                'max:100',
            ],

            'minimum_experience_years' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'application_url' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'application_deadline' => [
                'nullable',
                'date',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $job = JobOpportunity::create($validated);

        return response()->json([
            'message' => 'Job created successfully.',
            'job' => $job,
        ], 201);
    }

    /**
     * Update an existing job.
     */
    public function update(
        Request $request,
        JobOpportunity $job
    ) {
        $validated = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'company_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'country' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'employment_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'work_mode' => [
                'nullable',
                'string',
                'max:100',
            ],

            'minimum_experience_years' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'application_url' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'application_deadline' => [
                'nullable',
                'date',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $job->update($validated);

        return response()->json([
            'message' => 'Job updated successfully.',
            'job' => $job->fresh()->load('requirements'),
        ]);
    }

    /**
     * Activate or deactivate a job.
     */
    public function updateStatus(
        Request $request,
        JobOpportunity $job
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $job->update([
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'message' => $job->is_active
                ? 'Job activated successfully.'
                : 'Job deactivated successfully.',

            'job' => $job->fresh(),
        ]);
    }

    /**
     * Delete a job.
     */
    public function destroy(JobOpportunity $job)
    {
        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully.',
        ]);
    }
}
