<?php

declare(strict_types=1);

namespace App\Task\Application;

class TaskCommand
{
    public function __construct(
        private readonly string $title,
        private readonly string $priority,
        private readonly string | null $description = null,
        private readonly string | null $dueDate = null
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function priority(): string
    {
        return $this->priority;
    }

    public function description(): string | null
    {
        return $this->description;
    }

    public function dueDate(): string | null
    {
        return $this->dueDate;
    }
}
