<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::put('/user/update', [UserController::class, 'update']);
    Route::put('/user/reset-password', [UserController::class, 'updatePassword']);

    Route::post('/games', [GameController::class, 'create']);
    Route::get('/games', [GameController::class, 'showAll']);
    Route::get('/games/{game}', [GameController::class, 'showOne']);
    Route::put('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);

    Route::post('/categories', [CategoryController::class, 'create']);
});

