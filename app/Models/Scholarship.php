<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $table = 'scholarships';
    protected $primaryKey = 'scholarship_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'created_by_admin_id',
        'title',
        'provider_name',
        'description',
        'country',
        'field_of_study',
        'degree_level',
        'application_deadline',
        'external_link',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'application_deadline' => 'date',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id', 'user_id');
    }

    public function criteria()
    {
        return $this->hasMany(ScholarshipCriterion::class, 'scholarship_id', 'scholarship_id');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'scholarship_id', 'scholarship_id');
    }

    public function coverLetters()
    {
        return $this->hasMany(CoverLetter::class, 'scholarship_id', 'scholarship_id');
    }

    public function savedApplications()
    {
        return $this->hasMany(SavedApplication::class, 'scholarship_id', 'scholarship_id');
    }
}