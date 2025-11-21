<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Protect Posts CRUD operations (requires any logged-in user)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'home'])->name('dashboard');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Existing public routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Redirect root to posts index
Route::get('/', function () {
    return redirect('/posts');
});

// Admin Routes (requires 'auth' AND 'admin' privilege)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Breeze auth routes
require __DIR__.'/auth.php';
