<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\TaskManagers\TaskManager;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskManager $taskManager){}

    public function store(CreateTaskRequest $request): TaskResource|JsonResponse
    {
        try {
            return $this->taskManager->createTask($request);
        } catch (Exception $ex) {
            Log::error("[task] Failed to save task information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function update(int $id, UpdateTaskRequest $request): TaskResource|JsonResponse
    {
        try {
            return $this->taskManager->updateTask($id, $request);
        } catch (Exception $ex) {
            Log::error("[task] Failed to update task information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function index(): ResourceCollection|JsonResponse
    {
        try {
            return $this->taskManager->listTasks();
        } catch (Exception $ex) {
            Log::error("[task] Failed to fetch tasks");
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function show(int $id): TaskResource|JsonResponse
    {
        try {
            return $this->taskManager->getTask($id);
        } catch (Exception $ex) {
            Log::error("[task] Failed to fetch task");
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function destroy(int $taskId, Request $request): JsonResponse
    {
        try {
            return $this->taskManager->deleteTask($taskId, $request);
        } catch (Exception $ex) {
            Log::error("[task] Failed to delete information " . __CLASS__ . '::' . __METHOD__ . ' ' . $ex->getMessage());
            return response()->json(['code' => 500, 'message' => 'Server error'], 500);
        }
    }
}
