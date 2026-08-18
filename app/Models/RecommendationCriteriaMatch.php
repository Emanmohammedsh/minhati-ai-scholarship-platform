<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationCriteriaMatch extends Model
{
    use HasFactory;

    protected $table = 'recommendation_criteria_matches';
    protected $primaryKey = 'match_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // مافيه ولا عمود تاريخ بهاد الجدول
    public $timestamps = false;

    protected $fillable = [
        'recommendation_id',
        'criterion_id',
        'is_satisfied',
        'contribution_points',
    ];

    protected function casts(): array
    {
        return [
            'is_satisfied' => 'boolean',
            'contribution_points' => 'decimal:2',
        ];
    }

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id', 'recommendation_id');
    }

    public function criterion()
    {
        return $this->belongsTo(ScholarshipCriterion::class, 'criterion_id', 'criterion_id');
    }
}