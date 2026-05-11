<?php

/**
 * Šis modelis apraksta "Conversation" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user One".
     */
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user Two".
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "messages".
     */
    public function messages()
    {
        return $this->hasMany(ConversationMessage::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "latest Message".
     */
    public function latestMessage()
    {
        return $this->hasOne(ConversationMessage::class)->latestOfMany();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "other User".
     */
    public function otherUser(User $user)
    {
        return $this->user_one_id === $user->id ? $this->userTwo : $this->userOne;
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "scope For User".
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_one_id', $userId)->orWhere('user_two_id', $userId);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "pinned Messages".
     */
    public function pinnedMessages()
    {
        return $this->messages()->whereNotNull('pinned_at')->orderByDesc('pinned_at');
    }
}
