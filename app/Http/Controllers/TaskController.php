<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Создание задачи
    public function create(Request $request): JsonResponse
    {
        try
        {
            $task = $this->taskService->create($request->all());
            return response()->json($task, 201);
        }
        catch(ValidationException $e)
        {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }

    // Просмотр всех задач
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAll();
        return response()->json($tasks);
    }

    // Просмотр одной задачи
    public function show(int $id): JsonResponse
    {
        try
        {
            $task = $this->taskService->getById($id);
            return response()->json($task);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    // Обновление задачи
    public function update(Request $request, int $id): JsonResponse
    {
        try
        {
            $task = $this->taskService->update($id, $request->all());
            return response()->json($task);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Task not found'], 404);
        }
        catch(ValidationException $e)
        {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }

    // Удаление задачи
    public function delete(int $id): JsonResponse
    {
        try
        {
            $this->taskService->delete($id);
            return response()->json(['message' => 'Task deleted successfully']);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }


    // Для частичного обновления задачи (PATCH)
    public function partialUpdate(Request $request, int $id): JsonResponse
    {

        try
        {
            $data = $request->only(['title', 'description', 'status']);

            $task = $this->taskService->update($id, $data);

            return response()->json($task);

        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Task not found'], 404);
        }
        catch(ValidationException $e)
        {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }
}
