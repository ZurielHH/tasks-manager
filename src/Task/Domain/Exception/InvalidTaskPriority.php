<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class InvalidTaskPriority extends RuntimeException
{
    public static function createFromEmpty(): self
    {
        return new self('Prioridad de tarea es requerida.');
    }

    public static function createFromInvalidValue(string $priority): self
    {
        return new self(sprintf('Prioridad de tarea asignada: %s no es válida', $priority));
    }
}
