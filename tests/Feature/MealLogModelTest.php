<?php

use App\Models\User;
use App\Models\MealLog;

test('meal log belongs to user', function () {
    $user = User::factory()->create();
    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);
    
    expect($log->user->id)->toBe($user->id);
});

test('meal log has meal type', function () {
    $user = User::factory()->create();
    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'lunch',
        'food' => 'Chicken breast',
        'quantity' => 150,
        'calories' => 248,
    ]);
    
    expect($log->meal)->toBe('lunch');
});

test('meal log has food name', function () {
    $user = User::factory()->create();
    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'dinner',
        'food' => 'Salmon',
        'quantity' => 200,
        'calories' => 416,
    ]);
    
    expect($log->food)->toBe('Salmon');
});

test('meal log has quantity', function () {
    $user = User::factory()->create();
    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Egg',
        'quantity' => 100,
        'calories' => 155,
    ]);
    
    expect($log->quantity)->toBe(100);
});

test('meal log has calories', function () {
    $user = User::factory()->create();
    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Oatmeal',
        'quantity' => 200,
        'calories' => 136,
    ]);
    
    expect($log->calories)->toBe(136);
});

test('multiple meal logs can be created for same meal', function () {
    $user = User::factory()->create();
    
    MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'quantity' => 100,
        'calories' => 130,
    ]);
    
    MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Egg',
        'quantity' => 50,
        'calories' => 78,
    ]);
    
    expect(MealLog::where('user_id', $user->id)->where('meal', 'breakfast')->count())->toBe(2);
});
