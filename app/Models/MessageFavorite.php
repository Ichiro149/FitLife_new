<?php

/**
 * Šis modelis apraksta "Message Favorite" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageFavorite extends Model
{
    protected $fillable = ['user_id', 'message_type', 'message_id'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "message".
     */
    public function message()
    {
        return $this->morphTo();
    }
}
