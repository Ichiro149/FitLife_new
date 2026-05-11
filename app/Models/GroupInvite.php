<?php

/**
 * Šis modelis apraksta "Group Invite" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupInvite extends Model
{
    protected $fillable = ['group_id', 'sender_id', 'user_id', 'status'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "group".
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "sender".
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
