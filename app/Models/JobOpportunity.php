<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunity extends Model
{
    use HasFactory;

    protected $table = 'job_opportunities';

    protected $primaryKey = 'job_id';

    protected $fillable = [
        'title',
        'company_name',
        'description',
        'country',
        'city',
        'employment_type',
        'work_mode',
        'minimum_experience_years',
        'application_url',
        'application_deadline',
        'is_active',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'minimum_experience_years' => 'integer',
    ];

    /**
     * Requirements belonging to this job.
     */
    public function requirements()
    {
        return $this->hasMany(
            JobRequirement::class,
            'job_id',
            'job_id'
        );
    }

    /**
     * Recommendations generated for this job.
     */
    public function recommendations()
    {
        return $this->hasMany(
            JobRecommendation::class,
            'job_id',
            'job_id'
        );
    }
}
