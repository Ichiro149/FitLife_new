<?php

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use App\Models\CommentLike;

test('comment belongs to user', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Test post',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Test comment',
    ]);
    
    expect($comment->user->id)->toBe($user->id);
});

test('comment belongs to post', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Test post',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Test comment',
    ]);
    
    expect($comment->post->id)->toBe($post->id);
});

test('comment can have parent comment', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Test post',
        'views' => 0,
    ]);
    
    $parentComment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Parent comment',
    ]);
    
    $replyComment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'parent_id' => $parentComment->id,
        'content' => 'Reply comment',
    ]);
    
    expect($replyComment->parent->id)->toBe($parentComment->id);
});

test('comment can have replies', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Test post',
        'views' => 0,
    ]);
    
    $parentComment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Parent comment',
    ]);
    
    Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'parent_id' => $parentComment->id,
        'content' => 'Reply 1',
    ]);
    
    Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'parent_id' => $parentComment->id,
        'content' => 'Reply 2',
    ]);
    
    expect($parentComment->replies)->toHaveCount(2);
});

test('comment has likes relationship', function () {
    $user = User::factory()->create();
    $post = Post::create([
        'user_id' => $user->id,
        'content' => 'Test post',
        'views' => 0,
    ]);
    
    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Test comment',
    ]);
    
    CommentLike::create([
        'user_id' => $user->id,
        'comment_id' => $comment->id,
        'type' => 'like',
    ]);
    
    expect($comment->likes)->toHaveCount(1);
});
