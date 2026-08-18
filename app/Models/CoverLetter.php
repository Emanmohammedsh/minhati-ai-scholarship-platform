<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverLetter extends Model
{
    use HasFactory;

    protected $table = 'cover_letters';
    protected $primaryKey = 'cover_letter_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // عندها requested_at / completed_at بدل created/updated

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'content',
        'generation_status',
        'generation_time_ms',
        'requested_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'completed_at' => 'datetime',
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
}