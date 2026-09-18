<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequirement extends Model
{
    use HasFactory;

    protected $table = 'job_requirements';

    protected $primaryKey = 'requirement_id';

    protected $fillable = [
        'job_id',
        'requirement_type',
        'required_value',
        'is_mandatory',
        'weight',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'weight' => 'decimal:2',
    ];

    /**
     * Job opportunity this requirement belongs to.
     */
    public function job()
    {
        return $this->belongsTo(
            JobOpportunity::class,
            'job_id',
            'job_id'
        );
    }

    /**
     * Matching results related to this requirement.
     */
    public function matches()
    {
        return $this->hasMany(
            JobRequirementMatch::class,
            'requirement_id',
            'requirement_id'
        );
    }
}
