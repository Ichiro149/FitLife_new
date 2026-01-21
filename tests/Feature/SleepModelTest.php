<?php

use App\Models\User;
use App\Models\Sleep;

test('sleep belongs to user', function () {
    $user = User::factory()->create();
    $sleep = Sleep::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
        'duration' => 8,
    ]);
    
    expect($sleep->user->id)->toBe($user->id);
});

test('sleep has date attribute', function () {
    $user = User::factory()->create();
    $date = now()->toDateString();
    
    $sleep = Sleep::create([
        'user_id' => $user->id,
        'date' => $date,
        'start_time' => '23:00',
        'end_time' => '07:00',
        'duration' => 8,
    ]);
    
    expect($sleep->date)->toBe($date);
});

test('sleep has start and end time', function () {
    $user = User::factory()->create();
    
    $sleep = Sleep::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '22:30',
        'end_time' => '06:30',
        'duration' => 8,
    ]);
    
    expect($sleep->start_time)->toBe('22:30');
    expect($sleep->end_time)->toBe('06:30');
});

test('sleep has duration in hours', function () {
    $user = User::factory()->create();
    
    $sleep = Sleep::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
        'duration' => 8,
    ]);
    
    expect((float) $sleep->duration)->toBe(8.0);
});

test('sleep duration can be decimal', function () {
    $user = User::factory()->create();
    
    $sleep = Sleep::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '06:30',
        'duration' => 7.5,
    ]);
    
    expect((float) $sleep->duration)->toBe(7.5);
});
