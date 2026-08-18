<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $incrementing = true;
    protected $keyType = 'int';

    const UPDATED_AT = null; // بس created_at موجود

    protected $fillable = [
        'user_id',
        'saved_application_id',
        'notification_type',
        'reminder_window_days',
        'channel',
        'status',
        'scheduled_for',
        'sent_at',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'sent_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function savedApplication()
    {
        return $this->belongsTo(SavedApplication::class, 'saved_application_id', 'saved_application_id');
    }
}