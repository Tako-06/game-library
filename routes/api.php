<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::post('/games', [GameController::class, 'create']);

    Route::put('/user/update', [UserController::class, 'update']);
    Route::put('/user/reset-password', [UserController::class, 'updatePassword']);
});
