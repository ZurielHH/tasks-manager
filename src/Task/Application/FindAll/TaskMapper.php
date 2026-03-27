<?php

declare(strict_types=1);

namespace App\Task\Application\FindAll;

use App\Shared\Application\AuditTimestampsResponse;

class TaskMapper
{
    /**
     * @param array<string, mixed> $tasks
     * @return TaskResponse[]
     */
    public function map(array $tasks): array
    {
        return array_map(fn (array $task): TaskResponse => $this->transform($task), $tasks);
    }

    private function transform(array $task): TaskResponse
    {
        $auditTimestampsResponse = new AuditTimestampsResponse(
            $task['createdAt'] ?? '',
            $task['updatedAt'] ?? ''
        );

        return new TaskResponse(
            $task['id'] ?? '',
            $task['title'] ?? '',
            $task['priority'] ?? '',
            isset($task['completed']) && $task['completed'] === 1,
            $task['description'] ?? '',
            $task['dueDate'] ?? '',
            $auditTimestampsResponse
        );
    }
}
