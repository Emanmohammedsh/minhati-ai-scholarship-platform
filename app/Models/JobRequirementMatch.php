<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequirementMatch extends Model
{
    use HasFactory;

    protected $table = 'job_requirement_matches';

    protected $primaryKey = 'match_id';

    protected $fillable = [
        'job_recommendation_id',
        'requirement_id',
        'is_satisfied',
        'contribution_points',
    ];

    protected $casts = [
        'is_satisfied' => 'boolean',
        'contribution_points' => 'decimal:2',
    ];

    /**
     * Recommendation this requirement match belongs to.
     */
    public function recommendation()
    {
        return $this->belongsTo(
            JobRecommendation::class,
            'job_recommendation_id',
            'job_recommendation_id'
        );
    }

    /**
     * Requirement that was evaluated.
     */
    public function requirement()
    {
        return $this->belongsTo(
            JobRequirement::class,
            'requirement_id',
            'requirement_id'
        );
    }
}
