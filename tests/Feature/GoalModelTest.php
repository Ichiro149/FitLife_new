<?php

use App\Models\User;
use App\Models\Goal;
use App\Models\GoalLog;

test('goal belongs to user', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    expect($goal->user->id)->toBe($user->id);
});

test('goal has logs relationship', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    GoalLog::create([
        'goal_id' => $goal->id,
        'value' => 75,
        'change' => -5,
        'date' => now()->toDateString(),
    ]);
    
    expect($goal->logs)->toHaveCount(1);
});

test('goal casts target_value to decimal', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70.5,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    expect($goal->target_value)->toBe('70.50');
});

test('goal casts end_date to date', function () {
    $user = User::factory()->create();
    $endDate = now()->addMonth()->startOfDay();
    
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => $endDate,
    ]);
    
    expect($goal->end_date)->toBeInstanceOf(\Carbon\Carbon::class);
});

test('goal progress percent returns correct value', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 100,
        'current_value' => 50,
        'end_date' => now()->addMonth(),
    ]);
    
    expect($goal->progressPercent())->toBe(50.0);
});

test('goal progress percent handles zero target', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 0,
        'current_value' => 50,
        'end_date' => now()->addMonth(),
    ]);
    
    expect($goal->progressPercent())->toBe(0.0);
});

test('goal progress percent handles negative target', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => -10,
        'current_value' => 50,
        'end_date' => now()->addMonth(),
    ]);
    
    expect($goal->progressPercent())->toBe(0.0);
});
