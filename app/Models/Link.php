<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'slug',
        'target_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
