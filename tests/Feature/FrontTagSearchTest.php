<?php

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('tag story search matches normal search terms', function () {
    $author = User::factory()->create([
        'role' => UserRole::Writer,
    ]);

    $category = Category::create([
        'name' => 'Signals',
        'slug' => 'signals',
    ]);

    $tag = Tag::create([
        'name' => 'Space',
        'slug' => 'space',
    ]);

    $matchingPost = Post::create([
        'user_id' => $author->id,
        'category_id' => $category->id,
        'title' => 'The Wow Signal',
        'slug' => 'the-wow-signal',
        'excerpt' => 'A strange radio burst.',
        'content' => 'Deep space mystery.',
        'status' => PostStatus::Published,
        'updated_at' => now()->subMinute(),
    ]);

    $otherPost = Post::create([
        'user_id' => $author->id,
        'category_id' => $category->id,
        'title' => 'Lost Expedition',
        'slug' => 'lost-expedition',
        'excerpt' => 'A mountain mystery.',
        'content' => 'No radio evidence.',
        'status' => PostStatus::Published,
        'updated_at' => now()->subMinute(),
    ]);

    $tag->posts()->attach([$matchingPost->id, $otherPost->id]);

    $this->get(route('front.tags.show', ['tag' => $tag, 'search' => 'Wow']))
        ->assertOk()
        ->assertSee('The Wow Signal')
        ->assertDontSee('Lost Expedition');
});
