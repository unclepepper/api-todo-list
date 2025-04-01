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

    public function find($id)
    {
        return Task::find($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = Task::find($id);
        if ($task) {
            $task->update($data);
        }
        return $task;
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
        }
        return $task;
    }
}
