<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CvVersion extends Model
{
    protected $fillable = [
        'cv_id',
        'scholarship_id',
        'content',
        'applied_sections',
    ];

    protected $casts = [
        'content' => 'array',
        'applied_sections' => 'array',
    ];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class, 'cv_id', 'cv_id');
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(
            Scholarship::class,
            'scholarship_id',
            'scholarship_id'
        );
    }
}
