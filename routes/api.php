<?php

use App\Http\Controllers\Api\CreateTaskController;
use App\Http\Controllers\Api\DeleteTaskController;
use App\Http\Controllers\Api\GetAllTasksController;
use App\Http\Controllers\Api\GetTaskController;
use App\Http\Controllers\Api\UpdateTaskController;
use Illuminate\Support\Facades\Route;


// Создание задачи
Route::post('/tasks', CreateTaskController::class);

// Получение всех задач
Route::get('/tasks', GetAllTasksController::class);

// Получение одной задачи по ID
Route::get('/tasks/{id}', GetTaskController::class);

// Обновление задачи (полное)
Route::put('/tasks/{id}', [UpdateTaskController::class, 'update']);

// Обновление задачи (частичное)
Route::patch('/tasks/{id}', [UpdateTaskController::class, 'partialUpdate']);

// Удаление задачи по ID
Route::delete('/tasks/{id}', DeleteTaskController::class);
