<?php

use App\Models\User;
use App\Models\Sleep;

test('guests cannot access sleep tracker', function () {
    $response = $this->get('/tracker/sleep');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access sleep tracker', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/tracker/sleep');
    
    $response->assertOk();
});

test('users can log sleep record', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/sleep', [
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
    ]);
    
    $response->assertRedirect();
    
    $this->assertDatabaseHas('sleeps', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
    ]);
});

test('sleep duration is calculated correctly', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/tracker/sleep', [
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
    ]);
    
    $sleep = Sleep::where('user_id', $user->id)->first();
    expect($sleep->duration)->toBe(8.0);
});

test('overnight sleep duration calculated correctly', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/tracker/sleep', [
        'date' => now()->toDateString(),
        'start_time' => '22:30',
        'end_time' => '06:30',
    ]);
    
    $sleep = Sleep::where('user_id', $user->id)->first();
    expect($sleep->duration)->toBe(8.0);
});

test('sleep validation requires date', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/sleep', [
        'start_time' => '23:00',
        'end_time' => '07:00',
    ]);
    
    $response->assertSessionHasErrors('date');
});

test('sleep validation requires start time', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/sleep', [
        'date' => now()->toDateString(),
        'end_time' => '07:00',
    ]);
    
    $response->assertSessionHasErrors('start_time');
});

test('sleep validation requires end time', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/sleep', [
        'date' => now()->toDateString(),
        'start_time' => '23:00',
    ]);
    
    $response->assertSessionHasErrors('end_time');
});

test('sleep logs display average duration', function () {
    $user = User::factory()->create();
    
    Sleep::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
        'duration' => 8,
    ]);
    
    Sleep::create([
        'user_id' => $user->id,
        'date' => now()->subDay()->toDateString(),
        'start_time' => '00:00',
        'end_time' => '06:00',
        'duration' => 6,
    ]);
    
    $response = $this->actingAs($user)->get('/tracker/sleep');
    
    $response->assertOk();
    $response->assertViewHas('average', 7.0);
});

test('users only see their own sleep logs', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    Sleep::create([
        'user_id' => $user1->id,
        'date' => now()->toDateString(),
        'start_time' => '23:00',
        'end_time' => '07:00',
        'duration' => 8,
    ]);
    
    Sleep::create([
        'user_id' => $user2->id,
        'date' => now()->toDateString(),
        'start_time' => '22:00',
        'end_time' => '06:00',
        'duration' => 8,
    ]);
    
    $response = $this->actingAs($user1)->get('/tracker/sleep');
    
    $sleeps = $response->viewData('sleeps');
    expect($sleeps->count())->toBe(1);
    expect($sleeps->first()->user_id)->toBe($user1->id);
});
