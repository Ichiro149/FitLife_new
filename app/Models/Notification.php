<?php

/**
 * Šis modelis apraksta "Notification" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "sender".
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "notifiable".
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
