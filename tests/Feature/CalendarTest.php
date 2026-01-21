<?php

use App\Models\User;
use App\Models\Calendar;

test('guests cannot access calendar', function () {
    $response = $this->get('/calendar');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access calendar', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/calendar');
    
    $response->assertOk();
});

test('users can create calendar events', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/calendar', [
        'date' => now()->addDay()->toDateString(),
        'type' => 'workout',
        'description' => 'Morning workout session',
    ]);
    
    $response->assertJson(['success' => true]);
    
    $this->assertDatabaseHas('calendars', [
        'user_id' => $user->id,
        'type' => 'workout',
        'description' => 'Morning workout session',
        'completed' => false,
    ]);
});

test('calendar event requires date', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/calendar', [
        'type' => 'workout',
        'description' => 'Morning workout',
    ]);
    
    $response->assertSessionHasErrors('date');
});

test('calendar event requires valid type', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/calendar', [
        'date' => now()->addDay()->toDateString(),
        'type' => 'invalid-type',
        'description' => 'Test event',
    ]);
    
    $response->assertSessionHasErrors('type');
});

test('calendar supports various event types', function () {
    $user = User::factory()->create();
    
    $eventTypes = ['workout', 'rest', 'goal', 'running', 'gym', 'yoga', 'cardio', 'swimming'];
    
    foreach ($eventTypes as $type) {
        $response = $this->actingAs($user)->post('/calendar', [
            'date' => now()->addDay()->toDateString(),
            'type' => $type,
            'description' => "Test {$type} event",
        ]);
        
        $response->assertJson(['success' => true]);
    }
});

test('users can update calendar event completion status', function () {
    $user = User::factory()->create();
    
    $event = Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Test workout',
        'completed' => false,
    ]);
    
    $response = $this->actingAs($user)->patch("/calendar/{$event->id}", [
        'completed' => true,
    ]);
    
    $response->assertJson(['success' => true]);
    
    $event->refresh();
    expect($event->completed)->toBe(true);
});

test('users cannot update other users calendar events', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $event = Calendar::create([
        'user_id' => $user1->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Test workout',
        'completed' => false,
    ]);
    
    $response = $this->actingAs($user2)->patch("/calendar/{$event->id}", [
        'completed' => true,
    ]);
    
    $response->assertJson(['success' => false]);
});

test('users can fetch calendar events via AJAX', function () {
    $user = User::factory()->create();
    
    Calendar::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Morning workout',
        'completed' => false,
    ]);
    
    Calendar::create([
        'user_id' => $user->id,
        'date' => now()->addDays(5)->toDateString(),
        'type' => 'yoga',
        'description' => 'Yoga session',
        'completed' => false,
    ]);
    
    $response = $this->actingAs($user)->get('/calendar/events?' . http_build_query([
        'start' => now()->toDateString(),
        'end' => now()->addDays(10)->toDateString(),
    ]));
    
    $response->assertOk();
    expect($response->json())->toHaveCount(2);
});

test('users only see their own calendar events', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    Calendar::create([
        'user_id' => $user1->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'User 1 workout',
        'completed' => false,
    ]);
    
    Calendar::create([
        'user_id' => $user2->id,
        'date' => now()->toDateString(),
        'type' => 'running',
        'description' => 'User 2 running',
        'completed' => false,
    ]);
    
    $response = $this->actingAs($user1)->get('/calendar/events?' . http_build_query([
        'start' => now()->toDateString(),
        'end' => now()->addDays(10)->toDateString(),
    ]));
    
    $response->assertOk();
    expect($response->json())->toHaveCount(1);
    expect($response->json()[0]['type'])->toBe('workout');
});
