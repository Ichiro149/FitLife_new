<?php

/**
 * Šis modelis apraksta "Biography" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biography extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'height',
        'weight',
        'gender',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
