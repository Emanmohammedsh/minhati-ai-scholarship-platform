<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['skill_tag', 'title', 'url', 'provider', 'hours', 'is_free', 'language'];
}