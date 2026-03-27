<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class InvalidTaskDueDate extends RuntimeException
{
    public static function createFromInvalidFormat(): self
    {
        return new self('Fecha límite de tarea no tiene el formato correcto');
    }

    public static function createFromInvalidDueDate(): self
    {
        return new self('Fecha limite asignada a tarea es pasada.');
    }
}
