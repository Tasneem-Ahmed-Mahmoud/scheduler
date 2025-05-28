<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_url',
        'scheduled_time',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'platform_posts')
            ->withPivot('platform_status')
            ->withTimestamps();
    }

    public function scopeFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['from'])) {
            $query->whereDate('scheduled_time', '>=', $filters['from']);
        }

        if (isset($filters['to'])) {
            $query->whereDate('scheduled_time', '<=', $filters['to']);
        }

        return $query;
    }
}
