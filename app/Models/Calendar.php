<?php

/**
 * Šis modelis apraksta "Calendar" datus un saites ar citiem ierakstiem.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Calendar extends Model
{
    use HasFactory;

    public const PRESET_TYPES = [
        'workout',
        'rest',
        'goal',
        'running',
        'gym',
        'yoga',
        'cardio',
        'stretching',
        'cycling',
        'swimming',
        'weightlifting',
        'pilates',
        'hiking',
        'boxing',
        'dance',
        'crossfit',
        'walking',
        'meditation',
        'tennis',
        'basketball',
        'soccer',
        'climbing',
        'rowing',
        'martial_arts',
        'recovery',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'type',
        'custom_type',
        'description',
        'completed',
    ];

    protected $casts = [
        'date' => 'date',
        'completed' => 'boolean',
    ];

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "user".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Šī metode atgriež vai definē ar modeli saistīto loģiku "get Display Type Attribute".
     */
    public function getDisplayTypeAttribute(): string
    {
        if ($this->type === 'custom') {
            return $this->custom_type ?: __('calendar.type_custom');
        }

        $translationKey = 'calendar.type_'.$this->type;
        $translated = __($translationKey);

        if ($translated !== $translationKey) {
            return $translated;
        }

        return Str::headline(str_replace('_', ' ', $this->type));
    }
}
