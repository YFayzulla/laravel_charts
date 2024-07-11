<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Website;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard',[ Website ::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [PostController::class, 'index']);

Route::prefix('posts')->group(function () {
    Route::get('/fetchPosts', [PostController::class, 'fetchPosts']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('/{post}', [PostController::class, 'show']);
    Route::post('/{post}', [PostController::class, 'update']); // Change this to POST for updating
    Route::delete('/{post}', [PostController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
