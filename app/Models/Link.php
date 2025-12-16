<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function hits(): HasMany
    {
        return $this->hasMany(LinkHit::class);
    }
}
