<?php

namespace App\TaskManagers\Redmine;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RedmineTaskHelper
{
    public static function resource($response): TaskResource
    {
        $task = $response->json()['issue'] ?? [];
        return new TaskResource(self::getObject($task));
    }

    public static function collection($response): ResourceCollection
    {
        $tasks = $response->json()['issues'] ?? [];
        $tasks = collect($tasks)->map(fn($task) => self::getObject($task));

        return TaskResource::collection($tasks);
    }

    public static function getObject(array $task): object
    {
        return (object)[
            'id'           => $task['id'],
            'subject'      => $task['subject'],
            'description'  => $task['description'],
            'status'       => strtolower($task['status']['name']),
            'type'         => strtolower($task['tracker']['name']),
            'start_date'   => $task['start_date'],
            'due_date'     => $task['due_date'],
            'created_at'   => $task['created_on'],
            'updated_at'   => $task['updated_on'],
        ];
    }

    public static function getStatusId($status): ?int
    {
        return match ($status) {
            'new'         => 1,
            'in_progress' => 2,
            'resolved'    => 3,
            'feedback'    => 4,
            'closed'      => 5,
            'rejected'    => 6,
            'default'     => null,
        };
    }

    public static function getTaskTypeId($status): ?int
    {
        return match ($status) {
            'bug'     => 1,
            'feature' => 2,
            'support' => 3,
            'default' => null,
        };
    }
}
