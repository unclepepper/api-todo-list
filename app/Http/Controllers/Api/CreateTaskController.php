<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateTaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    /**
     * Создание новой задачи.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
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
}

