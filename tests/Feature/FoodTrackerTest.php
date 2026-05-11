<?php

/**
 * Šis tests pārbauda "Food Tracker Test" darbību un sagaidāmo uzvedību.
 */

use App\Models\MealLog;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('guests cannot access food tracker', function () {
    $response = $this->get('/tracker/foods');

    $response->assertRedirect('/login');
});

test('authenticated users can access food tracker', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/tracker/foods');

    $response->assertOk();
    $response->assertSee('data-meal-tracker=', false);
    $response->assertDontSee('{!! json_encode', false);
});

test('food tracker displays today summary', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/tracker/foods');

    $response->assertOk();
    $response->assertViewHas('todaySummary');
});

test('food lookup marks fallback results as local source', function () {
    Config::set('services.usda.key', 'test-key');

    Http::fake([
        'https://api.nal.usda.gov/*' => Http::response(['foods' => []], 200),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->postJson('/tracker/foods/lookup', [
            'query' => 'rice',
        ]);

    $response->assertOk();
    $response->assertJsonPath('source', 'local');
    $response->assertJsonPath('items.0.name', 'Rice');
});

test('food lookup maps usda results to meal tracker contract', function () {
    Config::set('services.usda.key', 'test-key');

    Http::fake([
        'https://api.nal.usda.gov/*' => Http::response([
            'foods' => [
                [
                    'description' => 'Banana, raw',
                    'servingSize' => 118,
                    'servingSizeUnit' => 'g',
                    'foodNutrients' => [
                        ['nutrientNumber' => '1008', 'nutrientName' => 'Energy', 'value' => 105],
                        ['nutrientNumber' => '1003', 'nutrientName' => 'Protein', 'value' => 1.3],
                        ['nutrientNumber' => '1004', 'nutrientName' => 'Total lipid (fat)', 'value' => 0.4],
                        ['nutrientNumber' => '1005', 'nutrientName' => 'Carbohydrate, by difference', 'value' => 27],
                    ],
                ],
            ],
        ], 200),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->postJson('/tracker/foods/lookup', [
            'query' => 'banana',
        ]);

    $response->assertOk();
    $response->assertJsonPath('source', 'api');
    $response->assertJsonPath('items.0.name', 'Banana, raw');
    $response->assertJsonPath('items.0.calories', 105);
    $response->assertJsonPath('items.0.serving_size', 118);
    $response->assertJsonPath('items.0.protein', 1.3);
    $response->assertJsonPath('items.0.fat', 0.4);
    $response->assertJsonPath('items.0.carbs', 27);
});

test('users can calculate calories', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->postJson('/tracker/foods/calculate', [
            'items' => [
                [
                    'food' => 'Rice',
                    'quantity' => 200,
                    'meal' => 'Breakfast',
                    'calories_per_serving' => 130,
                    'serving_size' => 100,
                    'protein' => 2.7,
                    'fat' => 0.3,
                    'carbs' => 28.2,
                ],
            ],
        ]);

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'Breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);
});

test('calories calculation for multiple foods', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->postJson('/tracker/foods/calculate', [
            'items' => [
                [
                    'food' => 'Rice',
                    'quantity' => 100,
                    'meal' => 'Breakfast',
                    'calories_per_serving' => 130,
                    'serving_size' => 100,
                    'protein' => 2.7,
                    'fat' => 0.3,
                    'carbs' => 28.2,
                ],
                [
                    'food' => 'Egg',
                    'quantity' => 100,
                    'meal' => 'Breakfast',
                    'calories_per_serving' => 155,
                    'serving_size' => 100,
                    'protein' => 13.0,
                    'fat' => 11.0,
                    'carbs' => 1.1,
                ],
                [
                    'food' => 'Chicken breast',
                    'quantity' => 150,
                    'meal' => 'Lunch',
                    'calories_per_serving' => 165,
                    'serving_size' => 100,
                    'protein' => 31.0,
                    'fat' => 3.6,
                    'carbs' => 0.0,
                ],
            ],
        ]);

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'Breakfast',
        'food' => 'Rice',
        'calories' => 130,
    ]);

    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'Breakfast',
        'food' => 'Egg',
        'calories' => 155,
    ]);

    $this->assertDatabaseHas('meal_logs', [
        'user_id' => $user->id,
        'meal' => 'Lunch',
        'food' => 'Chicken breast',
    ]);
});

test('food calculation requires items array', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/tracker/foods/calculate', []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors('items');
});

test('empty meals return error', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/tracker/foods/calculate', [
        'items' => [
            [
                'food' => '',
                'quantity' => 0,
                'meal' => 'Breakfast',
            ],
        ],
    ]);

    $response->assertUnprocessable();
});

test('meal logs are displayed in food tracker', function () {
    $user = User::factory()->create();

    MealLog::create([
        'user_id' => $user->id,
        'meal' => 'Breakfast',
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
        'meal' => 'Breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);

    MealLog::create([
        'user_id' => $user2->id,
        'meal' => 'Lunch',
        'food' => 'Chicken breast',
        'quantity' => 150,
        'calories' => 248,
    ]);

    $response = $this->actingAs($user1)->get('/tracker/foods');

    $logs = $response->viewData('mealLogs');
    expect($logs->count())->toBe(1);
    expect($logs->first()->user_id)->toBe($user1->id);
});

test('users can delete their own meal log', function () {
    $user = User::factory()->create();

    $log = MealLog::create([
        'user_id' => $user->id,
        'meal' => 'Breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);

    $response = $this->actingAs($user)->deleteJson("/tracker/foods/log/{$log->id}");

    $response->assertOk();
    $response->assertJson(['success' => true]);
    $this->assertDatabaseMissing('meal_logs', ['id' => $log->id]);
});

test('users cannot delete other users meal log', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $log = MealLog::create([
        'user_id' => $user2->id,
        'meal' => 'Breakfast',
        'food' => 'Rice',
        'quantity' => 200,
        'calories' => 260,
    ]);

    $response = $this->actingAs($user1)->deleteJson("/tracker/foods/log/{$log->id}");

    $response->assertForbidden();
    $this->assertDatabaseHas('meal_logs', ['id' => $log->id]);
});
