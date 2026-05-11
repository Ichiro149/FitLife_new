<?php

/**
 * Šis modelis apraksta "User" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'full_name',
        'username',
        'email',
        'password',
        'avatar',
        'banner',
        'weight',
        'height',
        'age',
        'gender',
        'activity_level',
        'goal_type',
        'role',
        'bio',
        'language',
        'last_seen_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Šī metode nosaka, kuru lauku izmantot maršrutu sasaistē.
     */
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "biography".
     */
    public function biography()
    {
        return $this->hasOne(Biography::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "posts".
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Šī metode aprēķina vai atgriež rādītāju "progress".
     */
    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "sleeps".
     */
    public function sleeps()
    {
        return $this->hasMany(Sleep::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "goals".
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "goal Logs".
     */
    public function goalLogs()
    {
        return $this->hasManyThrough(GoalLog::class, Goal::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "subscriptions".
     */
    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'subscribed_user_id')
            ->wherePivot('status', 'accepted')
            ->withPivot('status')
            ->distinct();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "sent Subscription Requests".
     */
    public function sentSubscriptionRequests()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "received Subscription Requests".
     */
    public function receivedSubscriptionRequests()
    {
        return $this->hasMany(Subscription::class, 'subscribed_user_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "likes".
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "comments".
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "calendars".
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "followers".
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "followings".
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    /**
     * Šī metode pārbauda nosacījumu "is Following".
     */
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "meal Logs".
     */
    public function mealLogs()
    {
        return $this->hasMany(MealLog::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "water Logs".
     */
    public function waterLogs()
    {
        return $this->hasMany(WaterLog::class);
    }

    /**
     * Šī metode pārbauda nosacījumu "has Subscription With".
     */
    public function hasSubscriptionWith(User $user): bool
    {
        return $this->subscriptions()->where('subscribed_user_id', $user->id)->exists();
    }

    /**
     * Šī metode pārbauda nosacījumu "has Pending Subscription To".
     */
    public function hasPendingSubscriptionTo(User $user): bool
    {
        return $this->sentSubscriptionRequests()
            ->where('subscribed_user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Šī metode pārbauda nosacījumu "has Pending Subscription From".
     */
    public function hasPendingSubscriptionFrom(User $user): bool
    {
        return $this->receivedSubscriptionRequests()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Šī metode pārbauda nosacījumu "has Role".
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Šī metode pārbauda nosacījumu "is Super Admin".
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Šī metode pārbauda nosacījumu "is Admin".
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "conversations".
     */
    public function conversations()
    {
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "groups".
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members')->withPivot('role')->withTimestamps();
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "group Invites".
     */
    public function groupInvites()
    {
        return $this->hasMany(GroupInvite::class, 'user_id')->where('status', 'pending');
    }

    /**
     * Šī metode pārbauda nosacījumu "is Mutual Follow".
     */
    public function isMutualFollow(User $user): bool
    {
        return $this->isFollowing($user) && $user->isFollowing($this);
    }

    /**
     * Šī metode pārbauda nosacījumu "is Online".
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(3));
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "get Admin Masked Email Attribute".
     */
    public function getAdminMaskedEmailAttribute(): string
    {
        $email = trim((string) $this->email);

        if ($email === '' || ! str_contains($email, '@')) {
            return 'Protected email';
        }

        [$localPart, $domainPart] = explode('@', $email, 2);

        return $this->maskEmailSegment($localPart, 2).'@'.$this->maskEmailSegment($domainPart, 1);
    }

    private function maskEmailSegment(string $value, int $visiblePrefix = 1): string
    {
        $length = Str::length($value);

        if ($length === 0) {
            return '';
        }

        if ($length === 1) {
            return '*';
        }

        $visible = min($visiblePrefix, max($length - 1, 1));

        return Str::substr($value, 0, $visible)
            .str_repeat('*', max($length - $visible, 1));
    }
}
