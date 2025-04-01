<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteTaskController extends Controller
{
    /**
     * Удаление задачи по ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try
        {
            $task = Task::findOrFail($id);

            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], 200);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }
}

