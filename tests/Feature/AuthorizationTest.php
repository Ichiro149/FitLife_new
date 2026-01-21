<?php

use App\Models\User;
use App\Models\Goal;
use App\Models\Post;
use App\Models\Calendar;
use App\Models\Comment;

test('users cannot access other users goal edit', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    $response = $this->actingAs($user2)->get("/goals/{$goal->id}/edit");
    
    $response->assertForbidden();
});

test('users cannot update other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    $response = $this->actingAs($user2)->patch("/goals/{$goal->id}", [
        'type' => 'weight',
        'target_value' => 50,
        'end_date' => now()->addMonths(2),
    ]);
    
    $response->assertForbidden();
});

test('users cannot delete other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    $response = $this->actingAs($user2)->delete("/goals/{$goal->id}");
    
    $response->assertForbidden();
    $this->assertDatabaseHas('goals', ['id' => $goal->id]);
});

test('users cannot log progress for other users goals', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $goal = Goal::create([
        'user_id' => $user1->id,
        'type' => 'weight',
        'target_value' => 70,
        'current_value' => 0,
        'end_date' => now()->addMonth(),
    ]);
    
    $response = $this->actingAs($user2)->post("/goals/{$goal->id}/log", [
        'value' => 75,
    ]);
    
    $response->assertForbidden();
});

test('users cannot update other users posts', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user1->id,
        'content' => 'Original content',
        'views' => 0,
    ]);
    
    $response = $this->actingAs($user2)->put("/posts/{$post->id}", [
        'content' => 'Hacked content',
    ]);
    
    $response->assertStatus(403);
});

test('users cannot delete other users posts', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user1->id,
        'content' => 'Protected content',
        'views' => 0,
    ]);
    
    $response = $this->actingAs($user2)->delete("/posts/{$post->id}");
    
    $response->assertStatus(403);
    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('users cannot update other users calendar events', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $event = Calendar::create([
        'user_id' => $user1->id,
        'date' => now()->toDateString(),
        'type' => 'workout',
        'description' => 'Test',
        'completed' => false,
    ]);
    
    $response = $this->actingAs($user2)->patch("/calendar/{$event->id}", [
        'completed' => true,
    ]);
    
    $response->assertJson(['success' => false]);
});

test('users can update their own comments', function () {
    $user = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Post content',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Original comment',
    ]);
    
    $response = $this->actingAs($user)->put("/comments/{$comment->id}", [
        'content' => 'Updated comment',
    ]);
    
    $response->assertOk();
    
    $comment->refresh();
    expect($comment->content)->toBe('Updated comment');
});

test('users cannot update other users comments', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user1->id,
        'content' => 'Post content',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user1->id,
        'post_id' => $post->id,
        'content' => 'Original comment',
    ]);
    
    $response = $this->actingAs($user2)->put("/comments/{$comment->id}", [
        'content' => 'Hacked comment',
    ]);
    
    $response->assertStatus(403);
});

test('users can delete their own comments', function () {
    $user = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Post content',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Comment to delete',
    ]);
    
    $response = $this->actingAs($user)->delete("/comments/{$comment->id}");
    
    $response->assertOk();
    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('users cannot delete other users comments', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $post = Post::create([
        'user_id' => $user1->id,
        'content' => 'Post content',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user1->id,
        'post_id' => $post->id,
        'content' => 'Protected comment',
    ]);
    
    $response = $this->actingAs($user2)->delete("/comments/{$comment->id}");
    
    $response->assertStatus(403);
    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});
