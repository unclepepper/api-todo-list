<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование создания задачи (POST /tasks)
     */
    public function test_create_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        // Проверка, что задача создана в базе данных
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'pending',
        ]);
    }

    /**
     * Тестирование получения всех задач (GET /tasks)
     */
    public function test_get_all_tasks()
    {
        // Создание нескольких задач
        Task::factory()->create([
            'title' => 'Test Task 1',
            'status' => 'pending',
        ]);
        Task::factory()->create([
            'title' => 'Test Task 2',
            'status' => 'completed',
        ]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /**
     * Тестирование получения одной задачи (GET /tasks/{id})
     */
    public function test_get_task_by_id()
    {
        $task = Task::factory()->create([
            'title' => 'Test Task',
            'status' => 'in_progress',
        ]);

        $response = $this->getJson('/api/tasks/'.$task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $task->id,
            'title' => $task->title,
            'status' => $task->status,
        ]);
    }

    /**
     * Тестирование обновления задачи (PUT /tasks/{id})
     */
    public function test_update_task()
    {
        $task = Task::factory()->create([
            'title' => 'Old Task Title',
            'status' => 'pending',
        ]);

        $data = [
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
        ];

        $response = $this->putJson('/api/tasks/'.$task->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $task->id,
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
        ]);

        // Проверка, что задача обновлена в базе данных
        $this->assertDatabaseHas('tasks', [
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
        ]);
    }

    /**
     * Тестирование удаления задачи (DELETE /tasks/{id})
     */
    public function test_delete_task()
    {
        $task = Task::factory()->create([
            'title' => 'Task to delete',
            'status' => 'pending',
        ]);

        $response = $this->deleteJson('/api/tasks/'.$task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Task deleted successfully'
        ]);

        // Проверка, что задача удалена из базы данных
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    /**
     * Тестирование попытки обновления несуществующей задачи (PUT /tasks/{id})
     */
    public function test_update_nonexistent_task()
    {
        $data = [
            'title' => 'Non-existent Task',
            'status' => 'pending',
        ];

        $response = $this->putJson('/api/tasks/999', $data);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Task not found'
        ]);
    }
}

