<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarshipCriterion extends Model
{
    use HasFactory;

    protected $table = 'scholarship_criteria';

    protected $primaryKey = 'criterion_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'scholarship_id',
        'criterion_type',
        'criterion_value',
        'weight',
        'is_mandatory',
    ];

    protected function casts(): array
    {
        return [
            'weight'       => 'decimal:2',
            'is_mandatory' => 'boolean',
            'created_at'   => 'datetime',
            'updated_at'   => 'datetime',
        ];
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id', 'scholarship_id');
    }
}
