<?php

declare(strict_types=1);

namespace App\Task\Application\MarkTaskCompleted;

use App\Task\Application\{TaskHandler, TaskQuery};

final class MarkTaskCompletedHandler extends TaskHandler
{
    public function __invoke(TaskQuery $query): void
    {
        $task = $this->findByIdentifier($this->buildIdentifier($query->id()));

        $task->markAsComplete();

        $this->repository->persist($task);
    }
}
