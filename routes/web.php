<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::post('/addLike', [LikeController::class, 'store'])->name('like.store');
Route::post('/addComment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/posts/game/{game}', [PostController::class, 'showPostsByGame'])->name('posts.game');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/posts/category/{category}', [PostController::class, 'showPostsByCategory'])->name('posts.category');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/create', [PostController::class, 'store'])->name('posts.store');
    Route::get('/your-posts', [PostController::class, 'personal'])->name('posts.personal');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

require __DIR__ . '/auth.php';
