<?php

use App\Models\User;
use App\Models\Biography;

test('biography belongs to user', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'full_name' => 'John Doe',
    ]);
    
    expect($biography->user->id)->toBe($user->id);
});

test('biography has full name', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'full_name' => 'John Smith',
    ]);
    
    expect($biography->full_name)->toBe('John Smith');
});

test('biography has age', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'age' => 25,
    ]);
    
    expect($biography->age)->toBe(25);
});

test('biography has height', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'height' => 180.5,
    ]);
    
    expect($biography->height)->toBe(180.5);
});

test('biography has weight', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'weight' => 75.5,
    ]);
    
    expect($biography->weight)->toBe(75.5);
});

test('biography has gender', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
        'gender' => 'male',
    ]);
    
    expect($biography->gender)->toBe('male');
});

test('biography fields are nullable', function () {
    $user = User::factory()->create();
    $biography = Biography::create([
        'user_id' => $user->id,
    ]);
    
    expect($biography->full_name)->toBeNull();
    expect($biography->age)->toBeNull();
    expect($biography->height)->toBeNull();
    expect($biography->weight)->toBeNull();
    expect($biography->gender)->toBeNull();
});

test('user can access biography through relationship', function () {
    $user = User::factory()->create();
    Biography::create([
        'user_id' => $user->id,
        'full_name' => 'Test User',
        'age' => 30,
    ]);
    
    expect($user->biography)->not->toBeNull();
    expect($user->biography->full_name)->toBe('Test User');
    expect($user->biography->age)->toBe(30);
});
