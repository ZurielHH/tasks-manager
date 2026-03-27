<?php

declare(strict_types=1);

namespace App\Task\Application\FindAll;

final readonly class FindAllTasksHandler
{
    public function __construct(
        private AllTasks $tasks,
        private TaskMapper $mapper
    ) {
    }

    public function __invoke(): array
    {
        $tasks = $this->tasks->read();

        return count($tasks) > 0 ? $this->mapper->map($tasks) : [];
    }
}
