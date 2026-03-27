<?php

declare(strict_types=1);

namespace App\Task\Application;

use App\Task\Domain\Service\TaskFinder;
use App\Task\Domain\Task;
use App\Task\Domain\TaskRepository;
use App\Task\Domain\Value_Object\TaskIdentifier;

abstract class TaskHandler
{
    private readonly TaskFinder $finder;

    public function __construct(protected readonly TaskRepository $repository)
    {
        $this->finder = new TaskFinder($this->repository);
    }

    public function findByIdentifier(TaskIdentifier $taskIdentifier): Task
    {
        return $this->finder->get($taskIdentifier);
    }

    protected function buildIdentifier(string $id): TaskIdentifier
    {
        return TaskIdentifier::create($id);
    }
}
