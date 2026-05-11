<?php

/**
 * Šis tests pārbauda "Authentication Test" darbību un sagaidāmo uzvedību.
 */

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

test('welcome page is accessible', function () {
    $response = $this->get('/');

    $response->assertOk();
});

test('login page is accessible', function () {
    $response = $this->get('/login');

    $response->assertOk();
});

test('register page is accessible', function () {
    $response = $this->get('/register');

    $response->assertOk();
});

test('privacy policy page is accessible', function () {
    $response = $this->get('/privacy-policy');

    $response->assertOk();
});

test('terms of service page is accessible', function () {
    $response = $this->get('/terms-of-service');

    $response->assertOk();
});

test('authenticated users are redirected from login to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/login');

    $response->assertRedirect('/dashboard');
});

test('authenticated users are redirected from register to dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/register');

    $response->assertRedirect('/dashboard');
});

test('guests are redirected from protected routes to login', function () {
    $protectedRoutes = [
        '/dashboard',
        '/profile',
        '/tracker/foods',
        '/tracker/sleep',
        '/tracker/water',
        '/goals',
        '/posts',
        '/calendar',
    ];

    foreach ($protectedRoutes as $route) {
        $response = $this->get($route);
        $response->assertRedirect('/login');
    }
});

test('users can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/dashboard');
});

test('users cannot login with invalid password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors();
});

test('users cannot login with non-existent email', function () {
    $response = $this->post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $this->assertAuthenticated();

    $response = $this->post('/logout');

    $this->assertGuest();
});

test('users can register with valid data', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser123',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'username' => 'testuser123',
    ]);
});

test('users cannot register with existing email', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser456',
        'email' => 'existing@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('users cannot register with existing username', function () {
    User::factory()->create(['username' => 'existinguser']);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'existinguser',
        'email' => 'new@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('username');
});

test('registration requires password confirmation', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'different-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('password');
});

test('users can generate a local password reset link without email delivery', function () {
    $user = User::factory()->create([
        'email' => 'resetme@example.com',
    ]);

    $response = $this->from('/forgot-password')->post('/forgot-password', [
        'email' => $user->email,
    ]);

    $response->assertRedirect('/forgot-password');
    $response->assertSessionHas('status');
    $response->assertSessionHas('reset_link');

    $resetLink = session('reset_link');

    expect($resetLink)->toContain('/reset-password/');
    expect($resetLink)->toContain('email='.urlencode($user->email));
});

test('users can reset password using generated local reset token', function () {
    $user = User::factory()->create([
        'email' => 'localreset@example.com',
        'password' => bcrypt('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $response = $this->post('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-secure-password',
        'password_confirmation' => 'new-secure-password',
    ]);

    $response->assertRedirect('/login');
    expect(Hash::check('new-secure-password', $user->fresh()->password))->toBeTrue();
});
