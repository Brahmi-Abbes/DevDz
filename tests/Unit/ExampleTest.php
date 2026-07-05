<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

// A post belongs to a user
it('belongs to a user', function () {
    $post = Post::factory()->create();
    expect($post->user)->toBeInstanceOf(User::class);
});

// A post can have tags
it('can have tags', function () {
    $post = Post::factory()->create();
    $tags = Tag::factory(3)->create();
    $post->tags()->attach($tags);
    expect($post->tags)->toHaveCount(3);
});