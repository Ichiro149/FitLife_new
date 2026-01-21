<?php

use App\Models\User;
use App\Models\WaterLog;

test('water log belongs to user', function () {
    $user = User::factory()->create();
    $log = WaterLog::create([
        'user_id' => $user->id,
        'amount' => 250,
    ]);
    
    expect($log->user->id)->toBe($user->id);
});

test('water log has amount attribute', function () {
    $user = User::factory()->create();
    $log = WaterLog::create([
        'user_id' => $user->id,
        'amount' => 500,
    ]);
    
    expect($log->amount)->toBe(500);
});

test('water log timestamps are set', function () {
    $user = User::factory()->create();
    $log = WaterLog::create([
        'user_id' => $user->id,
        'amount' => 250,
    ]);
    
    expect($log->created_at)->not->toBeNull();
    expect($log->updated_at)->not->toBeNull();
});

test('multiple water logs can be created', function () {
    $user = User::factory()->create();
    
    WaterLog::create(['user_id' => $user->id, 'amount' => 250]);
    WaterLog::create(['user_id' => $user->id, 'amount' => 300]);
    WaterLog::create(['user_id' => $user->id, 'amount' => 500]);
    
    expect(WaterLog::where('user_id', $user->id)->count())->toBe(3);
});
