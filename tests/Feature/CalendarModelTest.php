<?php

use App\Models\User;
use App\Models\Calendar;

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
    
    expect($event->date->toDateString())->toBe($date);
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
