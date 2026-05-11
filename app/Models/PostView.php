<?php

/**
 * Šis modelis apraksta "Post View" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "post".
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
