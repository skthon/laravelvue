<?php

namespace App\TaskManagers\Redmine;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class RedmineClient
{
    private PendingRequest $connection;

    private string $url;

    public function getProjectId()
    {
        return config('task_storage.redmine.project_id');
    }

    public function setConnection(): self
    {
        $this->connection = Http::withHeaders([
            'Content-Type'      => 'application/json',
            'X-Redmine-API-Key' => config('task_storage.redmine.api_key'),
        ]);

        return $this;
    }

    public function setUrl(?int $identifier = null): self
    {
        $this->url = config('task_storage.redmine.url');
        $this->url .= isset($identifier) ? "/issues/{$identifier}.json" : '/issues.json';

        return $this;
    }

    public function createIssue(array $postData): Response
    {
        return $this->connection->post($this->url, $postData);
    }

    public function updateIssue(array $postData): Response
    {
        return $this->connection->put($this->url, $postData);
    }

    public function deleteIssue(): Response
    {
        return $this->connection->delete($this->url);
    }

    public function listIssues(): Response
    {
        return $this->connection->get($this->url);
    }

    public function getIssue(): Response
    {
        return $this->connection->get($this->url);
    }
}
