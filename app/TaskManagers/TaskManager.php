<?php

namespace App\TaskManagers;

use Illuminate\Http\Request;

abstract class TaskManager
{
    abstract public function createTask(Request $request);

    abstract public function getTask(int $taskId);

    abstract public function listTasks();

    abstract public function updateTask(int $taskId, Request $request);

    abstract public function deleteTask(int $taskId);
}
