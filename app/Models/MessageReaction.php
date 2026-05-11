<?php

/**
 * Šis modelis apraksta "Message Reaction" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReaction extends Model
{
    protected $fillable = ['reactable_type', 'reactable_id', 'user_id', 'emoji'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "reactable".
     */
    public function reactable()
    {
        return $this->morphTo();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
