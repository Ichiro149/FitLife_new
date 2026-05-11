<?php

/**
 * Šis tests pārbauda "Admin Email Privacy Test" darbību un sagaidāmo uzvedību.
 */

use App\Models\User;

it('does not expose raw user emails in the admin users list', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = User::factory()->create([
        'email' => 'private.member@example.com',
        'role' => 'user',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.users'));

    $response->assertOk();
    $response->assertDontSee($member->email);
    $response->assertSeeText($member->admin_masked_email);
});

it('updates admin-managed users without requiring an email field', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = User::factory()->create([
        'email' => 'stays.private@example.com',
        'role' => 'user',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.users.update', $member), [
        'name' => 'Updated Member',
        'role' => 'user',
    ]);

    $response->assertRedirect(route('admin.users'));

    expect($member->fresh())
        ->name->toBe('Updated Member')
        ->role->toBe('user')
        ->email->toBe('stays.private@example.com');
});