<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function find($id): Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete($id): Task;
}
