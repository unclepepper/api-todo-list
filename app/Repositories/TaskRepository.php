<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::all();
    }

    public function find($id): Task
    {
        return Task::findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {

        if(!empty($data))
        {
            $task->update($data);
        }

        return $task;
    }

    public function delete($id): Task
    {
        $task = Task::findOrFail($id);

        if($task)
        {
            $task->delete();
        }
        return $task;
    }

}
