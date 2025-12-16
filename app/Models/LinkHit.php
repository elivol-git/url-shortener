<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkHit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'link_id',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
