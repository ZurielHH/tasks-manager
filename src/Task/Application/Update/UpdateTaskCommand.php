<?php

declare(strict_types=1);

namespace App\Task\Application\Update;

use App\Task\Application\TaskCommand;

final class UpdateTaskCommand extends TaskCommand
{
    public function __construct(
        private readonly string $id,
        string $title,
        string $priority,
        string | null $description = null,
        string | null $dueDate = null
    ) {
        parent::__construct($title, $priority, $description, $dueDate);
    }

    public function id(): string
    {
        return $this->id;
    }
}
