<?php

namespace Tests\Unit\TaskManagers;

use App\TaskManagers\Local\LocalTaskManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Task;

class LocalTaskManagerTest extends TestCase
{
    use RefreshDatabase;

    protected LocalTaskManager $taskManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->taskManager = new LocalTaskManager();
    }

    public function test_create_task()
    {
        $request = (new Request())->merge([
            'subject'     => 'Create a task management application',
            'description' => 'Task management application using redmine and mysql database',
            'status'      => 'in_progress',
            'type'        => 'bug',
            'due_date'    => now()->addDays(5)->format('Y-m-d'),
            'start_date'  => now()->format('Y-m-d'),
        ]);

        $this->taskManager->createTask($request);
        $this->assertDatabaseHas('tasks', $request->all());
    }

    public function test_update_task()
    {
        $task = Task::factory()->create();
        $request = (new Request())->merge([
            'subject'  => 'Create a task management application (updated)',
            'status'   => 'resolved',
        ]);

        $this->taskManager->updateTask($task->id, $request);
        $this->assertDatabaseHas('tasks', $request->all());
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();
        $this->taskManager->deleteTask($task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_list_tasks()
    {
        Task::factory(5)->create();
        $tasks = $this->taskManager->listTasks();
        $this->assertCount(5, $tasks);
    }

    public function test_get_task()
    {
        $task = Task::factory()->create();
        $response = $this->taskManager->getTask($task->id);

        $this->assertSame([
            'id'      => $task->id,
            'subject' => $task->subject,
        ], [
            'id'      => $response->id,
            'subject' => $response->subject,
        ]);
    }
}
