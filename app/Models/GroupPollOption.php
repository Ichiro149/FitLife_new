<?php

/**
 * Šis modelis apraksta "Group Poll Option" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPollOption extends Model
{
    public $timestamps = false;

    protected $fillable = ['group_poll_id', 'text', 'sort_order'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "poll".
     */
    public function poll()
    {
        return $this->belongsTo(GroupPoll::class, 'group_poll_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "votes".
     */
    public function votes()
    {
        return $this->hasMany(GroupPollVote::class);
    }
}
