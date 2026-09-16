<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    /**
     * Return all job applications for the authenticated user.
     */
    public function index(Request $request)
    {
        $applications = JobApplication::with('job')
            ->where('user_id', $request->user()->user_id)
            ->latest()
            ->get();

        return response()->json([
            'count' => $applications->count(),
            'applications' => $applications,
        ]);
    }

    /**
     * Save a job for the authenticated user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => [
                'required',
                'integer',
                'exists:job_opportunities,job_id',
            ],
        ]);

        $job = JobOpportunity::where('job_id', $validated['job_id'])
            ->where('is_active', true)
            ->first();

        if (!$job) {
            return response()->json([
                'message' => 'This job is not currently active.',
            ], 422);
        }

        $application = JobApplication::firstOrCreate(
            [
                'user_id' => $request->user()->user_id,
                'job_id' => $job->job_id,
            ],
            [
                'status' => 'saved',
                'applied_at' => null,
            ]
        );

        $application->load('job');

        return response()->json([
            'message' => $application->wasRecentlyCreated
                ? 'Job saved successfully.'
                : 'Job already saved.',
            'application' => $application,
        ], $application->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Update the application tracking status.
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        if ($application->user_id !== $request->user()->user_id) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'saved',
                    'applied',
                    'interview',
                    'accepted',
                    'rejected',
                ]),
            ],
        ]);

        $application->status = $validated['status'];

        if (
            $validated['status'] === 'applied'
            && $application->applied_at === null
        ) {
            $application->applied_at = Carbon::now();
        }

        $application->save();
        $application->load('job');

        return response()->json([
            'message' => 'Application status updated successfully.',
            'application' => $application,
        ]);
    }

    /**
     * Remove a saved/application record.
     */
    public function destroy(Request $request, JobApplication $application)
    {
        if ($application->user_id !== $request->user()->user_id) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        $application->delete();

        return response()->json([
            'message' => 'Job application removed successfully.',
        ]);
    }
}
