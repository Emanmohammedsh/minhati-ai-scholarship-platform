<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipCriterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'scholarship_id',
        'criterion',
        'weight',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}