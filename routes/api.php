<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
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
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [LoginController::class, 'register']);
    Route::delete('/logout', [LoginController::class, 'logout']);

    Route::group(['prefix' => '/profile'], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::delete('/', [ProfileController::class, 'remove']);
    })->middleware('auth:sanctum');

    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [UserController::class, 'list']);
        Route::get('/{id}', [UserController::class, 'index']);
    })->middleware('auth:sanctum');

    Route::group(['prefix' => '/posts'], function () {
        Route::get('/', [PostController::class, 'list']);
        Route::get('/{id}', [PostController::class, 'index']);
        Route::post('/=', [PostController::class, 'create']);
        Route::put('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'remove']);
    })->middleware('auth:sanctum');

    Route::group(['prefix' => '/comments'], function () {
        // /comments/?post_id=5 // получает все комментарии к посту
        Route::get('/', [CommentController::class, 'list']);
        Route::get('/{id}', [CommentController::class, 'index']);
        Route::post('/', [CommentController::class, 'create']);
        Route::put('/{id}', [CommentController::class, 'update']);
        Route::delete('/{id}', [CommentController::class, 'remove']);
    })->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});