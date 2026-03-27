<?php

declare(strict_types=1);

namespace App\Task\Application\Update;

use App\Task\Application\TaskHandler;

final class UpdateTaskHandler extends TaskHandler
{
    public function __invoke(UpdateTaskCommand $command): void
    {
        $taskIdentifier = $this->buildIdentifier($command->id());

        $task = $this->findByIdentifier($taskIdentifier);

        $task->update(
            $command->title(),
            $command->priority(),
            $command->description(),
            $command->dueDate()
        );

        $this->repository->persist($task);
    }
}
