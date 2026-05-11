<?php

/**
 * Šis modelis apraksta "Chat Theme" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatTheme extends Model
{
    protected $fillable = ['user_id', 'chat_type', 'chat_id', 'theme_key'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "chat".
     */
    public function chat()
    {
        return $this->morphTo();
    }
}
