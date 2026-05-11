<?php

/**
 * Šis modelis apraksta "Follow" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['follower_id', 'following_id'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "follower".
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "following".
     */
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
