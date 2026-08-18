<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $table = 'cvs';
    protected $primaryKey = 'cv_id';
    public $incrementing = true;
    protected $keyType = 'int';

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

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'reviewed_by_student' => 'boolean',
            'extracted_skills' => 'array',
            'extracted_education' => 'array',
            'extracted_qualifications' => 'array',
            'extraction_requested_at' => 'datetime',
            'extraction_completed_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'cv_id', 'cv_id');
    }
}