<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'currentUser'])->middleware('auth:sanctum');
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');

Route::get('/tasks/my', [TaskController::class, 'indexMy'])->middleware('auth:sanctum');
Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');
