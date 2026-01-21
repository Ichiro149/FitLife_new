<?php

use App\Models\User;
use App\Models\Biography;

test('guests cannot access biography page', function () {
    $response = $this->get('/biography');
    
    $response->assertRedirect('/login');
});

test('authenticated users can access biography edit page', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/biography');
    
    $response->assertOk();
});

test('users can create biography via store endpoint', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
        'age' => 25,
        'height' => 180,
        'weight' => 75,
        'gender' => 'male',
    ]);
    
    $response->assertRedirect('/biography');
    
    $this->assertDatabaseHas('biographies', [
        'user_id' => $user->id,
        'full_name' => 'John Doe',
        'age' => 25,
        'height' => 180,
        'weight' => 75,
        'gender' => 'male',
    ]);
});

test('users can update their biography', function () {
    $user = User::factory()->create();
    
    Biography::create([
        'user_id' => $user->id,
        'full_name' => 'John Doe',
        'age' => 25,
        'height' => 180,
        'weight' => 75,
        'gender' => 'male',
    ]);
    
    $response = $this->actingAs($user)->patch('/biography', [
        'full_name' => 'John Smith',
        'age' => 26,
        'height' => 181,
        'weight' => 73,
        'gender' => 'male',
    ]);
    
    $response->assertRedirect('/biography');
    
    $this->assertDatabaseHas('biographies', [
        'user_id' => $user->id,
        'full_name' => 'John Smith',
        'age' => 26,
    ]);
});

test('biography age must be positive integer', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
        'age' => -5,
    ]);
    
    $response->assertSessionHasErrors('age');
});

test('biography height must be positive', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
        'height' => -100,
    ]);
    
    $response->assertSessionHasErrors('height');
});

test('biography weight must be positive', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
        'weight' => -50,
    ]);
    
    $response->assertSessionHasErrors('weight');
});

test('biography gender must be valid option', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
        'gender' => 'invalid',
    ]);
    
    $response->assertSessionHasErrors('gender');
});

test('biography fields are nullable', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/biography', [
        'full_name' => 'John Doe',
    ]);
    
    $response->assertRedirect('/biography');
    
    $this->assertDatabaseHas('biographies', [
        'user_id' => $user->id,
        'full_name' => 'John Doe',
    ]);
});

test('biography page shows existing data', function () {
    $user = User::factory()->create();
    
    Biography::create([
        'user_id' => $user->id,
        'full_name' => 'Test User',
        'age' => 30,
        'height' => 175,
        'weight' => 70,
        'gender' => 'female',
    ]);
    
    $response = $this->actingAs($user)->get('/biography');
    
    $response->assertOk();
    $response->assertViewHas('biography');
});
