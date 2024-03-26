<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;


Route::get('/', [DashboardController::class, 'start'])->name('home');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}/edit', 'PostController@edit')->name('posts.edit');
Route::delete('/posts/{post}', 'PostController@destroy')->name('posts.destroy');

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/posts/{post}/comments', [CommentController::class, 'show'])->name('comments.show');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/');   // this is ghetto
    })->name('dashboard');
});
