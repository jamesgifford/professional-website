<?php

use App\Models\Post;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('career', 'career')->name('career');

Route::get('robots.txt', function () {
    return response("User-agent: *\nDisallow: /admin/\nDisallow: /dashboard\n\nSitemap: ".route('sitemap'), 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('sitemap.xml', function () {
    $posts = Post::query()->published()->latest('published_at')->get();
    $projects = Project::query()->published()->orderBy('sort_order')->get();

    return response()
        ->view('sitemap', compact('posts', 'projects'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Public thoughts (blog)
Route::get('thoughts', function () {
    return view('blog.index', [
        'posts' => Post::query()->published()->latest('published_at')->simplePaginate(5),
    ]);
})->name('blog.index');

Route::get('thoughts/{post:slug}', function (Post $post) {
    abort_unless($post->isPublished(), 404);

    return view('blog.show', ['post' => $post]);
})->name('blog.show');

// Public projects
Route::get('projects', function () {
    return view('projects.index', [
        'projects' => Project::query()->published()->orderBy('sort_order')->latest('published_at')->simplePaginate(5),
    ]);
})->name('projects.index');

Route::get('projects/{project:slug}', function (Project $project) {
    abort_unless($project->isPublished(), 404);

    return view('projects.show', [
        'project' => $project->load('screenshots'),
    ]);
})->name('projects.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Admin blog management
    Route::prefix('admin/blog')->name('admin.blog.')->group(function () {
        Route::view('/', 'admin.blog.index')->name('index');
        Route::view('create', 'admin.blog.create')->name('create');
        Route::get('{post}/edit', function (Post $post) {
            return view('admin.blog.edit', ['post' => $post]);
        })->name('edit');
    });

    // Admin project management
    Route::prefix('admin/projects')->name('admin.projects.')->group(function () {
        Route::view('/', 'admin.projects.index')->name('index');
        Route::view('create', 'admin.projects.create')->name('create');
        Route::get('{project}/edit', function (Project $project) {
            return view('admin.projects.edit', ['project' => $project]);
        })->name('edit');
    });
});

require __DIR__.'/settings.php';
