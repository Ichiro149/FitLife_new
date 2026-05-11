<?php

/**
 * Šis modelis apraksta "Subscription" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'subscribed_user_id',
        'status',
    ];

    public $timestamps = true;

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "subscriber".
     */
    public function subscriber()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "subscribed User".
     */
    public function subscribedUser()
    {
        return $this->belongsTo(User::class, 'subscribed_user_id');
    }
}