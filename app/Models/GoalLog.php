<?php

/**
 * Šis modelis apraksta "Goal Log" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'value',
        'date',
        'change',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'date' => 'date',
        'change' => 'integer',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "goal".
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
