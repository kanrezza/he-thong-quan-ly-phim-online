<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title', 'description', 'poster', 'video_url',
        'category_id', 'type', 'year', 'rating', 'status',
        'country', 'actors',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function watchlist(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function posterUrl(): string
    {
        if ($this->poster) {
            return asset('storage/' . $this->poster);
        }
        return '';
    }
}
