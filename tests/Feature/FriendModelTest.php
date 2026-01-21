<?php

use App\Models\User;
use App\Models\Friend;

test('friend has user relationship', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $friend = Friend::create([
        'user_id' => $user1->id,
        'friend_id' => $user2->id,
        'status' => 'pending',
    ]);
    
    expect($friend->user->id)->toBe($user1->id);
});

test('friend has friend relationship', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $friend = Friend::create([
        'user_id' => $user1->id,
        'friend_id' => $user2->id,
        'status' => 'pending',
    ]);
    
    expect($friend->friend->id)->toBe($user2->id);
});

test('friend has status pending', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $friend = Friend::create([
        'user_id' => $user1->id,
        'friend_id' => $user2->id,
        'status' => 'pending',
    ]);
    
    expect($friend->status)->toBe('pending');
});

test('friend status can be accepted', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $friend = Friend::create([
        'user_id' => $user1->id,
        'friend_id' => $user2->id,
        'status' => 'pending',
    ]);
    
    $friend->update(['status' => 'accepted']);
    
    expect($friend->status)->toBe('accepted');
});

test('friend can be deleted', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $friend = Friend::create([
        'user_id' => $user1->id,
        'friend_id' => $user2->id,
        'status' => 'accepted',
    ]);
    
    $friendId = $friend->id;
    $friend->delete();
    
    expect(Friend::find($friendId))->toBeNull();
});
