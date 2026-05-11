<?php

/**
 * Šis modelis apraksta "Goal" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'target_value',
        'current_value',
        'end_date',
        'change',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'end_date' => 'date',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "logs".
     */
    public function logs(): HasMany
    {
        return $this->hasMany(GoalLog::class);
    }

    /**
     * Šī metode aprēķina vai atgriež rādītāju "progress Percent".
     */
    public function progressPercent(): float
    {

        $target = (float) $this->target_value;
        $current = (float) $this->current_value;

        if ($target <= 0) {
            return 0.0;
        }

        $progress = ($current / $target) * 100.0;

        if ($progress < 0.0) {
            return 0.0;
        }

        return (float) min(100.0, round($progress, 2));
    }
}
