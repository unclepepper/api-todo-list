<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class GetTaskController extends Controller
{

    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Получение задачи по ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try
        {
            $task = $this->taskRepository->find($id);

            return response()->json($task);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }
}

