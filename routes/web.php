<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

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
});

require __DIR__.'/settings.php';
