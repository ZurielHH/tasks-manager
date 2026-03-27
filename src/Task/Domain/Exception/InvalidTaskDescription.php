<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class InvalidTaskDescription extends RuntimeException
{
    public static function createFromEmpty(): self
    {
        return new self('Descripción de tarea es requerida.');
    }

    public static function createFromInvalidLength(int $maxLength): self
    {
        return new self(
            sprintf(
                'Descripción de tarea debe tener una longitud menor a %d caracteres.',
                $maxLength
            )
        );
    }
}
