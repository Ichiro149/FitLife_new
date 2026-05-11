<?php

/**
 * Šis modelis apraksta "Comment" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'reply_to_id',
        'content',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "post".
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "parent".
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "reply To".
     */
    public function replyTo()
    {
        return $this->belongsTo(Comment::class, 'reply_to_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "replies".
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "likes".
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
