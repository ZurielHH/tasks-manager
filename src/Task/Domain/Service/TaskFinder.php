<?php

declare(strict_types=1);

namespace App\Task\Domain\Service;

use App\Task\Domain\{Exception\TaskNotFound, Task, TaskRepository};
use App\Task\Domain\Value_Object\TaskIdentifier;

final readonly class TaskFinder
{
    public function __construct(private TaskRepository $repository)
    {
    }

    public function get(TaskIdentifier $id): Task
    {
        $task = $this->repository->findById($id);

        if (null === $task) {
            throw TaskNotFound::createFromNotFound();
        }

        return $task;
    }
}
