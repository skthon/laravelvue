<?php

return [
    'default' => env('TASK_STORAGE', 'local'),

    'redmine' => [
        'url'        => env('REDMINE_URL', "http://localhost:8080"),
        'api_key'    => env('REDMINE_API_KEY', null),
        'project_id' => env('REDMINE_PROJECT_ID', 1),
    ]
];
