<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function index()
    {
        $cvs = Cv::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return response()->json($cvs);
    }

    public function show(Cv $cv)
    {
        $this->authorizeOwner($cv);
        return response()->json($cv);
    }

    /**
     * POST /api/cvs
     * FR-05 / FR-06: PDF only, max 5MB, stored and linked to the student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5120 KB = 5MB
        ], [
            'file.mimes' => 'PDF only.',
            'file.max'   => 'File exceeds 5MB.',
        ]);

        $file = $request->file('file');
        $storedPath = $file->store('cvs/' . Auth::id(), 'local');

        // US-01 alt scenario: the newly uploaded CV becomes the active one.
        Cv::where('user_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $cv = Cv::create([
            'user_id'           => Auth::id(),
            'file_path'         => $storedPath,
            'original_filename' => $file->getClientOriginalName(),
            'file_size_bytes'   => $file->getSize(),
            'mime_type'         => $file->getClientMimeType(),
            'is_active'         => true,
            'extraction_status' => 'pending',
        ]);

        return response()->json($cv, 201);
    }

    /**
     * POST /api/cvs/{cv}/extract
     * FR-07: run AI extraction. Kept as a separate call from store() so a
     * failed/timed-out extraction never costs the already-stored file.
     */
    public function extract(Cv $cv)
    {
        $this->authorizeOwner($cv);

        $cv->update([
            'extraction_status'       => 'processing',
            'extraction_requested_at' => now(),
        ]);

        try {
            $result = app(\App\Services\CvExtractionService::class)->extract($cv);

            $cv->update([
                'extraction_status'        => 'completed',
                'extracted_skills'         => $result['skills'] ?? [],
                'extracted_education'      => $result['education'] ?? [],
                'extracted_qualifications' => $result['qualifications'] ?? [],
                'extraction_completed_at'  => now(),
            ]);

            return response()->json($cv->fresh());
        } catch (\Throwable $e) {
            // US-03 alt scenario: extraction failing must not lose the CV.
            $cv->update(['extraction_status' => 'failed']);

            return response()->json([
                'message' => 'The AI service could not process this CV. Please try again.',
            ], 422);
        }
    }

    /**
     * PUT /api/cvs/{cv}/confirm
     * US-04: save the student's reviewed/edited version of the extracted data.
     */
    public function confirm(Request $request, Cv $cv)
    {
        $this->authorizeOwner($cv);

        $data = $request->validate([
            'skills'           => ['array'],
            'skills.*'         => ['string'],
            'education'        => ['array'],
            'qualifications'   => ['array'],
        ]);

        $cv->update([
            'extracted_skills'         => $data['skills'] ?? [],
            'extracted_education'      => $data['education'] ?? [],
            'extracted_qualifications' => $data['qualifications'] ?? [],
            'reviewed_by_student'      => true,
            'reviewed_at'              => now(),
        ]);

        return response()->json($cv->fresh());
    }

    public function download(Cv $cv)
    {
        $this->authorizeOwner($cv);
        if (! Storage::disk('local')->exists($cv->file_path)) {
            return response()->json(['message' => 'File not found on server.'], 404);
        }
        return Storage::disk('local')->download($cv->file_path, $cv->original_filename);
    }

    public function setActive(Cv $cv)
    {
        $this->authorizeOwner($cv);
        Cv::where('user_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);
        $cv->update(['is_active' => true]);
        return response()->json($cv);
    }

    public function destroy(Cv $cv)
    {
        $this->authorizeOwner($cv);
        if (Storage::disk('local')->exists($cv->file_path)) {
            Storage::disk('local')->delete($cv->file_path);
        }
        $cv->delete();
        return response()->json(['message' => 'CV deleted successfully.']);
    }

    private function authorizeOwner(Cv $cv): void
    {
        if ($cv->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this file.');
        }
    }
}