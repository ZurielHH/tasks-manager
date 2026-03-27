<?php

declare(strict_types=1);

namespace App\Task\Application\Find;

use App\Task\Application\{TaskHandler, TaskQuery};

final class FindTaskHandler extends TaskHandler
{
    public function __invoke(TaskQuery $query): array
    {
        $task = $this->findByIdentifier($this->buildIdentifier($query->id()));

        return [
            'id' => (string) $task->id(),
            'title' => (string) $task->title(),
            'priority' => (string) $task->priority(),
            'completed' => $task->isComplete(),
            'description' => $task->hasADescription() ? (string) $task->description() : '',
            'dueDate' => $task->hasADueDate() ? (string) $task->dueDate() : '',
        ];
    }
}
