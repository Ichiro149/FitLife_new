<?php

use App\Models\User;
use App\Models\WaterLog;

test('guests cannot access water tracker', function () {
    $response = $this->get('/tracker/water');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access water tracker', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/tracker/water');
    
    $response->assertOk();
});

test('users can log water intake', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/water', [
        'amount' => 250,
    ]);
    
    $response->assertRedirect();
    
    $this->assertDatabaseHas('water_logs', [
        'user_id' => $user->id,
        'amount' => 250,
    ]);
});

test('water amount validation requires numeric value', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/water', [
        'amount' => 'not-a-number',
    ]);
    
    $response->assertSessionHasErrors('amount');
});

test('water amount must be positive', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/water', [
        'amount' => -100,
    ]);
    
    $response->assertSessionHasErrors('amount');
});

test('water logs are displayed in index', function () {
    $user = User::factory()->create();
    
    WaterLog::create([
        'user_id' => $user->id,
        'amount' => 500,
    ]);
    
    WaterLog::create([
        'user_id' => $user->id,
        'amount' => 300,
    ]);
    
    $response = $this->actingAs($user)->get('/tracker/water');
    
    $response->assertOk();
    $response->assertViewHas('logs');
});

test('users only see their own water logs', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    WaterLog::create([
        'user_id' => $user1->id,
        'amount' => 500,
    ]);
    
    WaterLog::create([
        'user_id' => $user2->id,
        'amount' => 300,
    ]);
    
    $response = $this->actingAs($user1)->get('/tracker/water');
    
    $logs = $response->viewData('logs');
    expect($logs->count())->toBe(1);
    expect($logs->first()->user_id)->toBe($user1->id);
});
