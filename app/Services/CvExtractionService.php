<?php

namespace App\Services;

use App\Models\Cv;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class CvExtractionService
{
    /**
     * Step 1: read the raw text out of the stored PDF.
     * The OpenAI call (skills/education/qualifications extraction) is
     * added in a later step, on top of this raw text.
     */
    public function extract(Cv $cv): array
    {
        $absolutePath = Storage::disk('local')->path($cv->file_path);

        $parser = new Parser();
        $pdf = $parser->parseFile($absolutePath);
        $text = $pdf->getText();

        // Temporary: log the extracted text so we can eyeball it while
        // building this out, before the OpenAI call replaces this stub.
        \Log::info('CV raw text extracted', [
            'cv_id' => $cv->id,
            'text_preview' => mb_substr($text, 0, 500),
        ]);

        return [
            'skills'         => [],
            'education'      => [],
            'qualifications' => [],
            'raw_text'       => $text, // temporary, for verification only
        ];
    }
}