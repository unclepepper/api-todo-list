<?php

declare(strict_types=1);


namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskService
{

    /**
     *
     * Создание новой задачи
     *
     * @throws ValidationException
     */
    public function create(array $data)
    {
        $this->validate($data);

        return Task::create($data);
    }

    /**
     * Получение всех задач
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Task::all();
    }

    /**
     *
     * Получение задачи по ID
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        $task = Task::find($id);

        if(!$task)
        {
            throw new ModelNotFoundException("Task not found");
        }

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
    public function update(int $id, array $data): Task
    {

        $task = Task::findOrFail($id);

        /** Генерация правил валидации на основе переданных данных */
        $validationRules = $this->getValidationRules($data);

        $validator = Validator::make($data, $validationRules);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $task->update($data);

        return $task;
    }

    /**
     *
     * Удаление задачи
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        $task = $this->getById($id);

        $task->delete();

        return $task;
    }

    /**
     * Валидация данных для создания задачи
     *
     * @throws ValidationException
     */
    protected function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
    }

    /**
     * Метод для получения правил валидации в зависимости от переданных данных
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
}

