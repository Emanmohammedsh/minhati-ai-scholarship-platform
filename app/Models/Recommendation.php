<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $table = 'recommendations';
    protected $primaryKey = 'recommendation_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // ما فيه created_at/updated_at قياسيين، بس generated_at
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'cv_id',
        'match_score',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'match_score' => 'decimal:2',
            'generated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id', 'scholarship_id');
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id', 'cv_id');
    }

    public function criteriaMatches()
    {
        return $this->hasMany(RecommendationCriteriaMatch::class, 'recommendation_id', 'recommendation_id');
    }
}