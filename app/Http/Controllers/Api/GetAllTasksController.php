<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;

class GetAllTasksController extends Controller
{

    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Получение всех задач.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $tasks = $this->taskRepository->all();

        return response()->json($tasks);
    }
}

