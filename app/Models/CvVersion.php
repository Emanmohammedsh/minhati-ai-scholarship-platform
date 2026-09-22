<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvVersion extends Model
{
    protected $fillable = ['cv_id', 'scholarship_id', 'content', 'applied_sections'];

    protected $casts = [
        'content' => 'array',
        'applied_sections' => 'array',
    ];
}