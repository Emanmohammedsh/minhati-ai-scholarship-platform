<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'role',
        'full_name',
        'email',
        'password_hash',
        'is_active',
        'last_login_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password_hash' => 'hashed',
        ];
    }

    /**
     * Laravel's Auth system looks for a "password" column by default.
     * Our table uses "password_hash" instead, so we point Auth to it here.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * User → StudentProfile
     */
    public function studentProfile()
    {
        return $this->hasOne(
            StudentProfile::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Admin → Scholarships
     */
    public function createdScholarships()
    {
        return $this->hasMany(
            Scholarship::class,
            'created_by_admin_id',
            'user_id'
        );
    }
}