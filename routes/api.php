<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentsController;

Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/users/count', [UserController::class, 'countUsers']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Students listing for admin tips UI
Route::get('/students', [StudentsController::class, 'apiList']);
