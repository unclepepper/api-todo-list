<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::post('/tasks', [TaskController::class, 'create']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::patch('/tasks/{id}', [TaskController::class, 'partialUpdate']);
Route::delete('/tasks/{id}', [TaskController::class, 'delete']);
