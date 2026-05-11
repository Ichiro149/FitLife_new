<?php

/**
 * Šis modelis apraksta "Group Poll" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPoll extends Model
{
    protected $fillable = [
        'group_id', 'user_id', 'group_message_id',
        'question', 'is_anonymous', 'is_multiple', 'closes_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'is_multiple' => 'boolean',
            'closes_at' => 'datetime',
        ];
    }

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

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "message".
     */
    public function message()
    {
        return $this->belongsTo(GroupMessage::class, 'group_message_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "options".
     */
    public function options()
    {
        return $this->hasMany(GroupPollOption::class)->orderBy('sort_order');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "votes".
     */
    public function votes()
    {
        return $this->hasMany(GroupPollVote::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "total Votes".
     */
    public function totalVotes(): int
    {
        return $this->votes()->count();
    }

    /**
     * Šī metode pārbauda nosacījumu "is Closed".
     */
    public function isClosed(): bool
    {
        return $this->closes_at && $this->closes_at->isPast();
    }
}
