<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskService
{

    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Создание новой задачи
     *
     * @param array $data
     * @return Task
     * @throws ValidationException
     */
    public function create(array $data): Task
    {

        $validator = $this->validate($data);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }

        return $this->taskRepository->create($data);
    }

    /**
     * Обновление задачи
     *
     * @param int $id
     * @param array $data
     * @return Task
     * @throws ValidationException
     */
    public function update(int $id, array $data): Task
    {

        $task = $this->taskRepository->find($id);

        $validator = $this->validate($data);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $this->taskRepository->update($task, $data);

        return $task;
    }


    /**
     * Обновление задачи
     *
     * @param int $id
     * @param array $data
     * @return Task
     * @throws ValidationException
     */
    public function partialUpdate(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);

        /** Генерация правил валидации */
        $validationRules = $this->getValidationRules($data);

        /** Валидация данных */
        $validator = Validator::make($data, $validationRules);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $task->update($data);

        return $task;
    }

    /**
     * Метод для получения правил валидации
     *
     * @param array $data
     * @return array
     */
    private function getValidationRules(array $data): array
    {
        $rules = [];

        if(isset($data['title']))
        {
            $rules['title'] = 'nullable|string|max:255';
        }

        if(isset($data['description']))
        {
            $rules['description'] = 'nullable|string';
        }

        if(isset($data['status']))
        {
            $rules['status'] = 'nullable|in:pending,in_progress,completed';
        }

        return $rules;
    }

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public function validate(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
        ]);
    }
}

