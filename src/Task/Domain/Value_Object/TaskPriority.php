<?php

declare(strict_types=1);

namespace App\Task\Domain\Value_Object;

use App\Shared\Domain\ValueObject\StringValueObject;
use App\Task\Domain\Exception\InvalidTaskPriority;
use App\Task\Domain\Priority;

final class TaskPriority extends StringValueObject
{
    public static function create(string $priority): self
    {
        return new self($priority);
    }

    public static function createFromEnum(Priority $priority): self
    {
        return new self($priority->value);
    }

    private function __construct(string $priority)
    {
        $this->setPriority($priority);
    }

    private function setPriority(string $priority): void
    {
        if ($this->isEmpty($priority)) {
            throw InvalidTaskPriority::createFromEmpty();
        }

        $priority = Priority::createFromString($priority);

        $this->setValue($priority->value);
    }
}
