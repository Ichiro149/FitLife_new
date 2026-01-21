<?php

use App\Models\User;
use App\Models\Goal;
use App\Models\GoalLog;

test('guests cannot access goals', function () {
    $response = $this->get('/goals');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access goals index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/goals');
    
    $response->assertOk();
});

test('authenticated users can access goal creation form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/goals/create');
    
    $response->assertOk();
});

test('users can create a new goal', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/goals', [
        'type' => 'weight',
        'target_value' => 70,
        'description' => 'Lose weight to 70kg',
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response->assertRedirect('/goals');
    
    $this->assertDatabaseHas('goals', [
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
    ]);
});

test('goal creation requires type', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/goals', [
        'target_value' => 70,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response->assertSessionHasErrors('type');
});

test('goal creation requires target value', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/goals', [
        'type' => 'weight',
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response->assertSessionHasErrors('target_value');
});

test('goal creation requires future end date', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/goals', [
        'type' => 'weight',
        'target_value' => 70,
        'end_date' => now()->subDay()->toDateString(),
    ]);
    
    $response->assertSessionHasErrors('end_date');
});

test('users can view edit goal form', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user)->get("/goals/{$goal->id}/edit");
    
    $response->assertOk();
    $response->assertViewHas('goal');
});

test('users cannot edit other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user2)->get("/goals/{$goal->id}/edit");
    
    $response->assertForbidden();
});

test('users can update their goals', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user)->patch("/goals/{$goal->id}", [
        'type' => 'weight',
        'target_value' => 65,
        'end_date' => now()->addMonths(2)->toDateString(),
    ]);
    
    $response->assertRedirect('/goals');
    
    $goal->refresh();
    expect((float) $goal->target_value)->toBe(65.0);
});

test('users cannot update other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user2)->patch("/goals/{$goal->id}", [
        'type' => 'weight',
        'target_value' => 65,
        'end_date' => now()->addMonths(2)->toDateString(),
    ]);
    
    $response->assertForbidden();
});

test('users can delete their goals', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user)->delete("/goals/{$goal->id}");
    
    $response->assertRedirect('/goals');
    $this->assertDatabaseMissing('goals', ['id' => $goal->id]);
});

test('users cannot delete other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user2)->delete("/goals/{$goal->id}");
    
    $response->assertForbidden();
    $this->assertDatabaseHas('goals', ['id' => $goal->id]);
});

test('users can access goal log page', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user)->get("/goals/{$goal->id}/log");
    
    $response->assertOk();
});

test('users can log goal progress', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user)->post("/goals/{$goal->id}/log", [
        'value' => 75,
    ]);
    
    $response->assertRedirect('/goals');
    
    $goal->refresh();
    expect((float) $goal->current_value)->toBe(75.0);
    
    $this->assertDatabaseHas('goal_logs', [
        'goal_id' => $goal->id,
        'value' => 75,
    ]);
});

test('goal log creates change record', function () {
    $user = User::factory()->create();
    $goal = Goal::create([
        'user_id' => $user->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 80,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $this->actingAs($user)->post("/goals/{$goal->id}/log", [
        'value' => 78,
    ]);
    
    $log = GoalLog::where('goal_id', $goal->id)->first();
    expect((float) $log->change)->toBe(-2.0);
});

test('users only see their own goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    Goal::create([
        'user_id' => $user2->id,
        'type' => 'steps',
        'target_value' => 10000,
        'current_value' => 0,
        'end_date' => now()->addMonth()->toDateString(),
    ]);
    
    $response = $this->actingAs($user1)->get('/goals');
    
    $goals = $response->viewData('goals');
    expect($goals->count())->toBe(1);
    expect($goals->first()->user_id)->toBe($user1->id);
});
