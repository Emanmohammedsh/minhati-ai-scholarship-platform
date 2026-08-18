<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedApplication extends Model
{
    use HasFactory;

    protected $table = 'saved_applications';
    protected $primaryKey = 'saved_application_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // saved_at / status_updated_at بدل created/updated

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'status',
        'saved_at',
        'status_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'saved_at' => 'datetime',
            'status_updated_at' => 'datetime',
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

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'saved_application_id', 'saved_application_id');
    }
}