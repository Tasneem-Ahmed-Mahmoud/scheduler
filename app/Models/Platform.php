<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    protected $fillable = ['name', 'type', 'max_post_words_count','allow_post_without_image'];

    protected $table = 'platforms';

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class,'platform_posts')
                    ->withPivot('platform_status')
                    ->withTimestamps();
    }
}