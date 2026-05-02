<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::post('/categories', [CategoryController::class, 'create'])->middleware('auth:sanctum');
Route::post('/games', [GameController::class, 'create'])->middleware('auth:sanctum');
