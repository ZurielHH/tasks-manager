<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class TaskHasAlreadyBeenCompleted extends RuntimeException
{
    public static function createFromMessage(): self
    {
        return new self('La tarea ya ha sido completada.');
    }

    public static function createFromDueDate(): self
    {
        return new self('La tarea se encuentra vencida.');
    }
}
