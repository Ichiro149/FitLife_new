<?php

/**
 * Šis tests pārbauda "Calendar Model Test" darbību un sagaidāmo uzvedību.
 */

use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;

test('calendar belongs to user', function () {
    $user = User::factory()->create();
    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Test event',
        'completed' => false,
    ]);

    expect($event->user->id)->toBe($user->id);
});

test('calendar has date attribute', function () {
    $user = User::factory()->create();
    $date = now()->toDateString();

    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => $date,
        'type' => 'workout',
        'description' => 'Test event',
        'completed' => false,
    ]);

    expect(Carbon::parse($event->getAttribute('date'))->toDateString())->toBe($date);
});

test('calendar has type attribute', function () {
    $user = User::factory()->create();

    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'yoga',
        'description' => 'Test event',
        'completed' => false,
    ]);

    expect($event->type)->toBe('yoga');
});

test('calendar has completed attribute', function () {
    $user = User::factory()->create();

    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Test event',
        'completed' => false,
    ]);

    expect($event->completed)->toBeFalse();

    $event->update(['completed' => true]);

    expect($event->completed)->toBeTrue();
});

test('calendar description is nullable', function () {
    $user = User::factory()->create();

    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'rest',
        'completed' => false,
    ]);

    expect($event->description)->toBeNull();
});

test('calendar exposes custom display type label', function () {
    $user = User::factory()->create();

    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'custom',
        'custom_type' => 'Box 18:00',
        'description' => 'Custom event',
        'completed' => false,
    ]);

    expect($event->display_type)->toBe('Box 18:00');
});
