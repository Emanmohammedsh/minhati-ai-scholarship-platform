<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRecommendation extends Model
{
    use HasFactory;

    protected $table = 'job_recommendations';

    protected $primaryKey = 'job_recommendation_id';

    protected $fillable = [
        'user_id',
        'job_id',
        'cv_id',
        'match_score',
        'generated_at',
    ];

    protected $casts = [
        'match_score' => 'decimal:2',
        'generated_at' => 'datetime',
    ];

    /**
     * User who received this recommendation.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Job opportunity matched with the user.
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
     * CV used when generating the recommendation.
     */
    public function cv()
    {
        return $this->belongsTo(
            Cv::class,
            'cv_id',
            'cv_id'
        );
    }

    /**
     * Individual requirement matching results.
     */
    public function requirementMatches()
    {
        return $this->hasMany(
            JobRequirementMatch::class,
            'job_recommendation_id',
            'job_recommendation_id'
        );
    }
}
