<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $primaryKey = 'job_application_id';

    protected $fillable = [
        'user_id',
        'job_id',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function job()
    {
        return $this->belongsTo(
            JobOpportunity::class,
            'job_id',
            'job_id'
        );
    }
}
