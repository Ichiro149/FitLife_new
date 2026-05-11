<?php

/**
 * Šis modelis apraksta "Group Message" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $fillable = [
        'group_id', 'user_id', 'body', 'media_path', 'media_type',
        'audio_path', 'audio_duration',
        'edited_at', 'reply_to_id', 'forwarded_from_id', 'pinned_at',
        'file_path', 'file_name', 'file_size',
    ];

    protected function casts(): array
    {
        return [
            'edited_at' => 'datetime',
            'pinned_at' => 'datetime',
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
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "reply To".
     */
    public function replyTo()
    {
        return $this->belongsTo(self::class, 'reply_to_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "forwarded From".
     */
    public function forwardedFrom()
    {
        return $this->belongsTo(self::class, 'forwarded_from_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "reactions".
     */
    public function reactions()
    {
        return $this->morphMany(MessageReaction::class, 'reactable');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "favorites".
     */
    public function favorites()
    {
        return $this->morphMany(MessageFavorite::class, 'message');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "poll".
     */
    public function poll()
    {
        return $this->hasOne(GroupPoll::class);
    }
}
