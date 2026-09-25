<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'read_at',
    ];

    protected $appends = [
        'display_title',
        'display_message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_for' => 'datetime',
            'sent_at' => 'datetime',
            'created_at' => 'datetime',
            'read_at' => 'datetime',
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

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function getIsReadAttribute(): bool
    {
        return ! is_null($this->read_at);
    }

    public function getDisplayTitleAttribute(): string
    {
        return match ($this->notification_type) {
            'deadline_reminder' => 'تذكير بموعد نهائي',
            default => 'إشعار',
        };
    }

    public function getDisplayMessageAttribute(): string
    {
        $scholarshipTitle = $this->savedApplication?->scholarship?->title ?? 'المنحة';

        return match ($this->notification_type) {
            'deadline_reminder' => "اقترب الموعد النهائي للتقديم على: {$scholarshipTitle}",
            default => '',
        };
    }
}