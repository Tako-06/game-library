<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/current-user', [UserController::class, 'getUser']);
    Route::put('/users/update', [UserController::class, 'update']);
    Route::put('/users/reset-password', [UserController::class, 'updatePassword']);

    Route::post('/games', [GameController::class, 'create']);
    Route::get('/games', [GameController::class, 'showAll']);
    Route::get('/games/{game}', [GameController::class, 'showOne']);
    Route::put('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);

    Route::post('/categories', [CategoryController::class, 'create']);
    Route::get('/categories', [CategoryController::class, 'showAll']);
    Route::get('/categories/{category}', [CategoryController::class, 'showOne']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'delete']);
});


