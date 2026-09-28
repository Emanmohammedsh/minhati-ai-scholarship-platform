<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunityTranslation extends Model
{
    use HasFactory;

    protected $table = 'job_opportunity_translations';

    protected $primaryKey = 'translation_id';

    protected $fillable = [
        'job_id',
        'locale',
        'title',
        'description',
    ];

    public function job()
    {
        return $this->belongsTo(
            JobOpportunity::class,
            'job_id',
            'job_id'
        );
    }
}