<?php

namespace App\TaskManagers\Local;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\TaskManagers\TaskManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LocalTaskManager extends TaskManager
{
    public function createTask(Request $request): TaskResource
    {
        $task = new Task();
        $task->fill($request->only([
            'subject', 'description', 'status', 'type', 'due_date', 'start_date',
        ]));
        $task->save();

        $task->refresh();

        return new TaskResource($task);
    }

    public function updateTask(int $taskId, Request $request)
    {
        $task = Task::findOrFail($taskId);

        $task->subject = $request->get('subject', $task->subject);
        $task->description = $request->get('description', $task->description);
        $task->status = $request->get('status', $task->type);
        $task->type = $request->get('type', $task->type);
        $task->due_date = $request->get('due_date', $task->due_date);
        $task->start_date = $request->get('start_date', $task->start_date);

        $task->save();
        $task->refresh();

        return new TaskResource($task);
    }

    public function deleteTask(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return response()->json();
    }

    public function listTasks(): ResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function getTask(int $taskId): TaskResource
    {
        $task = Task::findOrFail($taskId);

        return new TaskResource($task);
    }
}
