<?php

/**
 * Šis modelis apraksta "Group Member" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $fillable = ['group_id', 'user_id', 'role', 'last_read_message_id'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "group".
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
