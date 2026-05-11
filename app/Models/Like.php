<?php

/**
 * Šis modelis apraksta "Like" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'type',
        'is_like',
    ];

    protected $casts = [
        'type' => 'string',
        'is_like' => 'boolean',
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
