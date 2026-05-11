<?php

/**
 * Šis modelis apraksta "Comment Like" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id',
        'type',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "comment".
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
