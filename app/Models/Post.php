<?php

/**
 * Šis modelis apraksta "Post" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'media_path',
        'media_type',
        'views',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "comments".
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "all Comments".
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "likes".
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "post Views".
     */
    public function postViews()
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "get View Count".
     */
    public function getViewCount(): int
    {
        return $this->postViews()->count();
    }

    /**
     * Šī metode pārbauda nosacījumu "is Liked By".
     */
    public function isLikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'post')->where('is_like', true)->exists();
    }

    /**
     * Šī metode pārbauda nosacījumu "is Disliked By".
     */
    public function isDislikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'post')->where('is_like', false)->exists();
    }
}
