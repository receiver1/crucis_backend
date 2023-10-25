<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/v1'], function () {
    Route::post('/login', [AuthenticateController::class, 'login']);
    Route::post('/register', [AuthenticateController::class, 'register']);
    Route::delete('/logout', [AuthenticateController::class, 'logout'])
        ->middleware('auth:sanctum');

    Route::group(['prefix' => '/profile', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::delete('/', [ProfileController::class, 'remove']);
    });

    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [UserController::class, 'list'])->middleware('auth:sanctum');
        Route::get('/{user}', [UserController::class, 'index']);
        Route::delete('/{user}', [UserController::class, 'remove']);
    });

    Route::get('/posts/', [PostController::class, 'list']);
    Route::get('/posts/{id}/', [PostController::class, 'index']);
    Route::group(['prefix' => '/posts', 'middleware' => 'auth:sanctum'], function () {
        Route::post('/{post}/like', [PostController::class, 'like']);
        Route::delete('/{post}/like', [PostController::class, 'unlike']);
        Route::post('/', [PostController::class, 'create']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'remove']);
    });

    Route::get('/comments/', [CommentController::class, 'list']);
    Route::get('/comments/{comment}', [CommentController::class, 'index']);
    Route::group(['prefix' => '/comments', 'middleware' => 'auth:sanctum'], function () {
        Route::post('/', [CommentController::class, 'create']);
        Route::put('/{comment}', [CommentController::class, 'update']);
        Route::delete('/{comment}', [CommentController::class, 'remove']);
    });

    Route::group(['prefix' => 'media', 'middleware' => 'auth:sanctum'], function () {
        Route::post('/', [MediaController::class, 'create']);
        Route::delete('/', [MediaController::class, 'remove']);
    });
});