<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReactionController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\UserController;

// Public
Route::get('/', [HomeController::class, 'index']);

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

// Auth only
Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy']);

    // Posts
    Route::get('/posts/create', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Votes
    Route::post('/posts/{post}/upvote',   [VoteController::class, 'upvote']);
    Route::post('/posts/{post}/downvote', [VoteController::class, 'downvote']);

    // Save
    Route::post('/posts/{post}/save', [SavedPostController::class, 'store']);
    Route::get('/saved', [SavedPostController::class, 'index']);

    // Comments
    Route::post('/posts/{post}/comments',    [CommentController::class, 'store']);
    Route::delete('/comments/{comment}',     [CommentController::class, 'destroy']);

    // Comment reactions
    Route::post('/comments/{comment}/like',    [CommentReactionController::class, 'like']);
    Route::post('/comments/{comment}/dislike', [CommentReactionController::class, 'dislike']);

    
    Route::get('users/{user}/edit', [UserController::class, 'edit']);
    Route::put('/users/{user}', [UserController::class, 'update']);

});
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/posts/{post}', [PostController::class, 'index']);
