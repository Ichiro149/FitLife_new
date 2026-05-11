<?php

/**
 * Šis modelis apraksta "Group" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['owner_id', 'name', 'description', 'avatar'];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "owner".
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "members".
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('role')->withTimestamps();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "messages".
     */
    public function messages()
    {
        return $this->hasMany(GroupMessage::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "invites".
     */
    public function invites()
    {
        return $this->hasMany(GroupInvite::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "latest Message".
     */
    public function latestMessage()
    {
        return $this->hasOne(GroupMessage::class)->latestOfMany();
    }

    /**
     * Šī metode pārbauda nosacījumu "has Member".
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('group_members.user_id', $user->id)->exists();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "get Member Role".
     */
    public function getMemberRole(User $user): ?string
    {
        return $this->members()->where('group_members.user_id', $user->id)->value('group_members.role');
    }

    /**
     * Šī metode pārbauda nosacījumu "is Admin".
     */
    public function isAdmin(User $user): bool
    {
        $role = $this->getMemberRole($user);
        return in_array($role, ['owner', 'admin']);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "pinned Messages".
     */
    public function pinnedMessages()
    {
        return $this->messages()->whereNotNull('pinned_at')->orderByDesc('pinned_at');
    }
}
