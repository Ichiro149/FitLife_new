<?php

/**
 * Šis modelis apraksta "Group Poll Vote" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPollVote extends Model
{
    protected $fillable = ['group_poll_id', 'group_poll_option_id', 'user_id'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "poll".
     */
    public function poll()
    {
        return $this->belongsTo(GroupPoll::class, 'group_poll_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "option".
     */
    public function option()
    {
        return $this->belongsTo(GroupPollOption::class, 'group_poll_option_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
