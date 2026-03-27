<?php

declare(strict_types=1);

namespace App\Task\Application\Create;

use App\Task\Application\TaskCommand;
use App\Task\Domain\Service\GenerateTaskIdentifier;
use App\Task\Domain\{Task, TaskRepository};

final readonly class CreateTaskHandler
{
    public function __construct(
        private TaskRepository $repository,
        private GenerateTaskIdentifier $generateIdentifier
    ) {
    }

    public function __invoke(TaskCommand $command): void
    {
        $task = $this->buildTask($command);

        $this->repository->persist($task);
    }

    private function buildTask(TaskCommand $command): Task
    {
        $identifier = $this->generateIdentifier->create();

        return Task::create(
            $identifier,
            $command->title(),
            $command->priority(),
            $command->description(),
            $command->dueDate()
        );
    }
}
