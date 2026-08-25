<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cv extends Model
{
    protected $table = 'cvs';
    protected $primaryKey = 'cv_id';

    protected $fillable = [
        'user_id',
        'file_path',
        'original_filename',
        'file_size_bytes',
        'mime_type',
        'is_active',
        'extraction_status',
        'extracted_skills',
        'extracted_education',
        'extracted_qualifications',
        'extraction_requested_at',
        'extraction_completed_at',
        'reviewed_by_student',
        'reviewed_at',
    ];

    protected $casts = [
        'is_active'                => 'boolean',
        'reviewed_by_student'      => 'boolean',
        'extracted_skills'         => 'array',
        'extracted_education'      => 'array',
        'extracted_qualifications' => 'array',
        'extraction_requested_at'  => 'datetime',
        'extraction_completed_at'  => 'datetime',
        'reviewed_at'              => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}