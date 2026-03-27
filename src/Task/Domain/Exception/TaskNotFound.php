<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class TaskNotFound extends RuntimeException
{
    public static function createFromNotFound(): self
    {
        return new self('Tarea no encontrada.');
    }
}
