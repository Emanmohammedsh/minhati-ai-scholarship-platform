<?php

namespace App\Services;

use App\Models\Cv;

class CvExtractionService
{
    /**
     * TODO: Replace this stub with a real call to an AI service once an
     * API key is available. Extract the PDF text first (e.g. with the
     * smalot/pdfparser package) then send it to the model with a prompt
     * asking for skills / education / qualifications as structured JSON.
     *
     * Returning empty arrays here (not fabricated data) keeps the
     * frontend review screen accurate to what real extraction should do —
     * per US-03's rule not to invent data for sections that aren't found.
     */
    public function extract(Cv $cv): array
    {
        return [
            'skills'         => [],
            'education'      => [],
            'qualifications' => [],
        ];
    }
}