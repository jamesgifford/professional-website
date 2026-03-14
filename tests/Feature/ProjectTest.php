<?php

use App\Models\Project;
use App\Models\User;

test('projects index page loads successfully', function () {
    $this->get(route('projects.index'))->assertStatus(200);
});

test('projects index shows published projects', function () {
    $published = Project::factory()->create(['name' => 'Published Project']);
    $draft = Project::factory()->draft()->create(['name' => 'Draft Project']);

    $this->get(route('projects.index'))
        ->assertSee('Published Project')
        ->assertDontSee('Draft Project');
});

test('project show page displays a published project', function () {
    $project = Project::factory()->create([
        'name' => 'My Test Project',
        'technologies' => ['Laravel', 'Tailwind CSS'],
    ]);

    $this->get(route('projects.show', $project))
        ->assertStatus(200)
        ->assertSee('My Test Project')
        ->assertSee('Laravel')
        ->assertSee('Tailwind CSS');
});

test('project show page returns 404 for draft projects', function () {
    $project = Project::factory()->draft()->create();

    $this->get(route('projects.show', $project))->assertStatus(404);
});

test('admin projects index requires authentication', function () {
    $this->get(route('admin.projects.index'))->assertRedirect(route('login'));
});

test('admin projects index loads for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.projects.index'))
        ->assertStatus(200);
});

test('admin project create page requires authentication', function () {
    $this->get(route('admin.projects.create'))->assertRedirect(route('login'));
});

test('admin project edit page loads for authenticated users', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.projects.edit', $project))
        ->assertStatus(200);
});
