<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CommentController;
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

    Route::group(['prefix' => '/users', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [UserController::class, 'list']);
        Route::get('/{user}', [UserController::class, 'index']);
    });

    Route::group(['prefix' => '/posts', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [PostController::class, 'list']);
        Route::get('/{post}', [PostController::class, 'index']);
        Route::post('/=', [PostController::class, 'create']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'remove']);
    });

    Route::group(['prefix' => '/comments', 'middleware' => 'auth:sanctum'], function () {
        // /comments/?post_id=5 // получает все комментарии к посту
        Route::get('/', [CommentController::class, 'list']);
        Route::get('/{comment}', [CommentController::class, 'index']);
        Route::post('/', [CommentController::class, 'create']);
        Route::put('/{comment}', [CommentController::class, 'update']);
        Route::delete('/{comment}', [CommentController::class, 'remove']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});