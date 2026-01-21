<?php

use App\Models\User;
use App\Models\MealLog;

test('guests cannot access food tracker', function () {
    $response = $this->get('/tracker/foods');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access food tracker', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/tracker/foods');
    
    $response->assertOk();
});

test('food tracker displays list of foods', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/tracker/foods');
    
    $response->assertOk();
    $response->assertViewHas('foods');
});

test('users can calculate calories', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->post('/tracker/foods/calculate', [
            'meals' => [
                'breakfast' => [
                    ['food' => 'Rice', 'quantity' => 200],
                ],
            ],
        ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
    
    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260, // 130 per 100g * 2
    ]);
});

test('calories calculation for multiple foods', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->post('/tracker/foods/calculate', [
            'meals' => [
                'breakfast' => [
                    ['food' => 'Rice', 'quantity' => 100],
                    ['food' => 'Egg', 'quantity' => 100],
                ],
                'lunch' => [
                    ['food' => 'Chicken breast', 'quantity' => 150],
                ],
            ],
        ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
    
    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'calories' => 130,
    ]);
    
    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Egg',
        'calories' => 155,
    ]);
    
    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'lunch',
        'food' => 'Chicken breast',
    ]);
});

test('food calculation requires meals array', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/foods/calculate', []);
    
    $response->assertSessionHasErrors('meals');
});

test('empty meals return error', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/tracker/foods/calculate', [
        'meals' => [
            'breakfast' => [],
        ],
    ]);
    
    $response->assertJson(['success' => false]);
});

test('meal logs are displayed in food tracker', function () {
    $user = User::factory()->create();
    
    MealLog::create([
        'user_id' => $user->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);
    
    $response = $this->actingAs($user)->get('/tracker/foods');
    
    $response->assertOk();
    $response->assertViewHas('mealLogs');
});

test('users only see their own meal logs', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    MealLog::create([
        'user_id' => $user1->id,
        'meal' => 'breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);
    
    MealLog::create([
        'user_id' => $user2->id,
        'meal' => 'lunch',
        'food' => 'Chicken breast',
        'quantity' => 150,
        'calories' => 248,
    ]);
    
    $response = $this->actingAs($user1)->get('/tracker/foods');
    
    $logs = $response->viewData('mealLogs');
    expect($logs->count())->toBe(1);
    expect($logs->first()->user_id)->toBe($user1->id);
});
