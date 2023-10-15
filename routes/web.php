<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
        Route::post('/users', [UserController::class, 'update'])->name('user.update');

        Route::post('/posts', [PostController::class, 'store'])->name('post.store');
        Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');

        Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');


        Route::post('/likes', [LikeController::class, 'store'])->name('like.store');
        Route::delete('/likes/{id}', [LikeController::class, 'destroy'])->name('like.destroy');
});

require __DIR__.'/auth.php';
