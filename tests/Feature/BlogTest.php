<?php

use App\Models\Post;
use App\Models\User;

test('blog index page loads successfully', function () {
    $this->get(route('blog.index'))->assertStatus(200);
});

test('blog index shows published posts', function () {
    $published = Post::factory()->create(['title' => 'Published Post']);
    $draft = Post::factory()->draft()->create(['title' => 'Draft Post']);

    $this->get(route('blog.index'))
        ->assertSee('Published Post')
        ->assertDontSee('Draft Post');
});

test('blog index shows posts in reverse chronological order', function () {
    $older = Post::factory()->create([
        'title' => 'Older Post',
        'published_at' => now()->subDays(5),
    ]);
    $newer = Post::factory()->create([
        'title' => 'Newer Post',
        'published_at' => now()->subDay(),
    ]);

    $response = $this->get(route('blog.index'));
    $response->assertSeeInOrder(['Newer Post', 'Older Post']);
});

test('blog show page displays a published post', function () {
    $post = Post::factory()->create(['title' => 'My Test Post']);

    $this->get(route('blog.show', $post))
        ->assertStatus(200)
        ->assertSee('My Test Post');
});

test('blog show page returns 404 for draft posts', function () {
    $post = Post::factory()->draft()->create();

    $this->get(route('blog.show', $post))->assertStatus(404);
});

test('admin blog index requires authentication', function () {
    $this->get(route('admin.blog.index'))->assertRedirect(route('login'));
});

test('admin blog index loads for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.blog.index'))
        ->assertStatus(200);
});

test('admin blog create page requires authentication', function () {
    $this->get(route('admin.blog.create'))->assertRedirect(route('login'));
});

test('admin blog edit page requires authentication', function () {
    $post = Post::factory()->create();

    $this->get(route('admin.blog.edit', $post))->assertRedirect(route('login'));
});

test('admin blog edit page loads for authenticated users', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.blog.edit', $post))
        ->assertStatus(200);
});
