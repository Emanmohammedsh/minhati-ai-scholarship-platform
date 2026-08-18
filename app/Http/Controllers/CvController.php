<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    /**
     * GET /api/cvs
     * All CVs belonging to the authenticated user
     */
    public function index()
    {
        $cvs = Cv::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($cvs);
    }

    /**
     * GET /api/cvs/{cv}
     */
    public function show(Cv $cv)
    {
        $this->authorizeOwner($cv);

        return response()->json($cv);
    }

    /**
     * POST /api/cvs
     * Upload a new CV (PDF/DOCX) — extraction happens later (FR-07)
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // 10MB
        ]);

        $file = $request->file('file');

        $storedPath = $file->store('cvs/' . Auth::id(), 'local');

        // If the user uploads a new active CV, deactivate the old one (optional, per FR-06 logic)
        Cv::where('user_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $cv = Cv::create([
            'user_id'            => Auth::id(),
            'file_path'          => $storedPath,
            'original_filename'  => $file->getClientOriginalName(),
            'file_size_bytes'    => $file->getSize(),
            'mime_type'          => $file->getClientMimeType(),
            'is_active'          => true,
            'extraction_status'  => 'pending',
        ]);

        // TODO: dispatch a Job/Queue here for the AI extraction step — outside this controller's scope
        // ExtractCvDataJob::dispatch($cv);

        return response()->json($cv, 201);
    }

    /**
     * GET /api/cvs/{cv}/download
     */
    public function download(Cv $cv)
    {
        $this->authorizeOwner($cv);

        if (! Storage::disk('local')->exists($cv->file_path)) {
            return response()->json(['message' => 'File not found on server.'], 404);
        }

        return Storage::disk('local')->download(
            $cv->file_path,
            $cv->original_filename
        );
    }

    /**
     * PATCH /api/cvs/{cv}/set-active
     * Marks a specific CV as active (deactivating the rest)
     */
    public function setActive(Cv $cv)
    {
        $this->authorizeOwner($cv);

        Cv::where('user_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $cv->update(['is_active' => true]);

        return response()->json($cv);
    }

    /**
     * DELETE /api/cvs/{cv}
     */
    public function destroy(Cv $cv)
    {
        $this->authorizeOwner($cv);

        if (Storage::disk('local')->exists($cv->file_path)) {
            Storage::disk('local')->delete($cv->file_path);
        }

        $cv->delete();

        return response()->json(['message' => 'CV deleted successfully.']);
    }

    /**
     * Ensures the CV belongs to the authenticated user
     */
    private function authorizeOwner(Cv $cv): void
    {
        if ($cv->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this file.');
        }
    }
}