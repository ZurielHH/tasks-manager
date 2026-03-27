<?php

declare(strict_types=1);

namespace App\Task\Domain;

use App\Task\Domain\Value_Object\TaskIdentifier;

interface TaskRepository
{
    public function findById(TaskIdentifier $id): Task | null;

    public function persist(Task $task): void;
}
