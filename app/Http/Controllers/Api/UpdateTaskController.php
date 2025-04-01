<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateTaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    /**
     * Обновление задачи.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try
        {
            /** Валидация данных для полного обновления задачи */
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|in:pending,in_progress,completed',
            ]);

            // Обновление задачи через сервис
            $task = $this->taskService->update($id, $validated);

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

    /**
     * Обновление задачи (вся или частичная).
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function partialUpdate(Request $request, int $id): JsonResponse
    {
        try
        {
            /** Получаем данные из запроса и передаем в сервис */
            $data = $request->only(['title', 'description', 'status']);
            $task = $this->taskService->partialUpdate($id, $data);

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

