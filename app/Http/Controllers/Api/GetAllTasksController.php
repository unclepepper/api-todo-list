<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class GetAllTasksController extends Controller
{
    /**
     * Получение всех задач.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json($tasks);
    }
}

