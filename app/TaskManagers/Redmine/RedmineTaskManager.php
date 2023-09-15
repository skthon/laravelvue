<?php

namespace App\TaskManagers\Redmine;

use App\Http\Resources\TaskResource;
use App\TaskManagers\TaskManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RedmineTaskManager extends TaskManager
{
    public function __construct(public readonly RedmineClient $redmineClient = new RedmineClient())
    {
    }

    public function createTask(Request $request): TaskResource
    {
        $postData = [
            'issue' => [
                'project_id'  => $this->redmineClient->getProjectId(),
                'subject'     => $request->get('subject'),
                'description' => $request->get('description'),
                'tracker_id'  => RedmineTaskHelper::getTaskTypeId($request->get('type', 'feature')),
                'status_id'   => RedmineTaskHelper::getStatusId($request->get('status', 'new')),
                'start_date'  => $request->get('start_date'),
                'due_date'    => $request->get('due_date'),
            ],
        ];

        $response = $this->redmineClient->setConnection()
            ->setUrl()
            ->createIssue($postData);

        if ($response->status() == 201) {
            return RedmineTaskHelper::resource($response);
        }

        throw new \Exception("Could not crate task");
    }

    public function updateTask(int $taskId, Request $request): TaskResource
    {
        $postData = [
            'issue' => array_filter([
                'project_id'  => $this->redmineClient->getProjectId(),
                'subject'     => $request->get('subject'),
                'description' => $request->get('description'),
                'tracker_id'  => $request->get('type') ? RedmineTaskHelper::getTaskTypeId($request->get('type')) : null,
                'status_id'   => $request->get('status') ? RedmineTaskHelper::getStatusId($request->get('status')) : null,
                'start_date'  => $request->get('start_date'),
                'due_date'    => $request->get('due_date'),
            ]),
        ];

        $response = $this->redmineClient->setConnection()
            ->setUrl($taskId)
            ->updateIssue($postData);

        if ($response->status() == 204) {
            return $this->getTask($taskId);
        }

        throw new \Exception("Could not update task");
    }

    public function deleteTask(int $taskId): JsonResponse
    {
        $response = $this->redmineClient->setConnection()
            ->setUrl($taskId)
            ->deleteIssue();

        if ($response->status() == 204) {
            return response()->json();
        }

        throw new \Exception("Could not delete task");
    }

    public function listTasks(): ResourceCollection
    {
        $response = $this->redmineClient->setConnection()
            ->setUrl()
            ->listIssues();

        if ($response->status() == 200) {
            return RedmineTaskHelper::collection($response);
        }

        throw new \Exception("Could not fetch tasks");
    }

    public function getTask(int $taskId): TaskResource
    {
        $response = $this->redmineClient->setConnection()
            ->setUrl($taskId)
            ->getIssue();

        if ($response->status() == 200) {
            return RedmineTaskHelper::resource($response);
        }

        throw new \Exception("Could not fetch task");
    }
}
