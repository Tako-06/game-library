<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::post('/categories', [CategoryController::class, 'create'])->middleware('auth:sanctum');
Route::post('/games', [GameController::class, 'create'])->middleware('auth:sanctum');

Route::get('/games', [GameController::class, 'showAll'])->middleware('auth:sanctum');
Route::get('/games/{game}', [GameController::class, 'showOne'])->middleware('auth:sanctum');
Route::put('/games/{game}', [GameController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/games/{game}', [GameController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'showAll'])->middleware('auth:sanctum');
Route::get('/categories/{category}', [CategoryController::class, 'showOne'])->middleware('auth:sanctum');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->middleware('auth:sanctum');
