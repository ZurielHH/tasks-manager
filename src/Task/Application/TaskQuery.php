<?php

declare(strict_types=1);

namespace App\Task\Application;

final readonly class TaskQuery
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
