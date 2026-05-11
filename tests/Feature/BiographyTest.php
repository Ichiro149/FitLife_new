<?php

/**
 * Šis tests pārbauda "Biography Test" darbību un sagaidāmo uzvedību.
 */

use App\Models\User;

test('guests cannot access profile edit page', function () {
    $response = $this->get('/profile');

    $response->assertRedirect('/login');
});

test('authenticated users can access profile edit page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
});

test('users can update personal info fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'      => $user->name,
        'username'  => $user->username,
        'email'     => $user->email,
        'full_name' => 'John Doe',
        'age'       => 25,
        'height'    => 180,
        'weight'    => 75,
        'gender'    => 'male',
    ]);

    $response->assertRedirect('/profile');

    $this->assertDatabaseHas('users', [
        'id'        => $user->id,
        'full_name' => 'John Doe',
        'age'       => 25,
        'gender'    => 'male',
    ]);
});

test('users can update personal info without optional fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'     => $user->name,
        'username' => $user->username,
        'email'    => $user->email,
    ]);

    $response->assertRedirect('/profile');
});

test('age must be a positive integer', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'     => $user->name,
        'username' => $user->username,
        'email'    => $user->email,
        'age'      => -5,
    ]);

    $response->assertSessionHasErrors('age');
});

test('height must be a positive number', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'     => $user->name,
        'username' => $user->username,
        'email'    => $user->email,
        'height'   => -100,
    ]);

    $response->assertSessionHasErrors('height');
});

test('weight must be a positive number', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'     => $user->name,
        'username' => $user->username,
        'email'    => $user->email,
        'weight'   => -50,
    ]);

    $response->assertSessionHasErrors('weight');
});

test('gender must be a valid option', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name'     => $user->name,
        'username' => $user->username,
        'email'    => $user->email,
        'gender'   => 'invalid',
    ]);

    $response->assertSessionHasErrors('gender');
});

test('full_name field is saved on profile update', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->patch('/profile', [
        'name'      => $user->name,
        'username'  => $user->username,
        'email'     => $user->email,
        'full_name' => 'John Doe',
    ]);

    $this->assertDatabaseHas('users', [
        'id'        => $user->id,
        'full_name' => 'John Doe',
    ]);
});

test('profile edit page loads for user with existing data', function () {
    $user = User::factory()->create([
        'full_name' => 'Test User',
        'age'       => 30,
        'height'    => 175,
        'weight'    => 70,
        'gender'    => 'female',
    ]);

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
    $response->assertSee('Test User');
});
