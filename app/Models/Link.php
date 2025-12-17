<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory;

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

    public function scopeSlugSearch(Builder $query, ?string $slug): Builder
    {
        return $query->when($slug, fn ($q) =>
            $q->where('slug', 'like', "%{$slug}%")
        );
    }
}
