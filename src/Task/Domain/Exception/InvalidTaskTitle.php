<?php

declare(strict_types=1);

namespace App\Task\Domain\Exception;

use RuntimeException;

final class InvalidTaskTitle extends RuntimeException
{
    public static function createFromEmpty(): self
    {
        return new self('Título es requerido.');
    }

    public static function createFromInvalidLength(int $minLength, int $maxLength): self
    {
        return new self(sprintf('Título debe tener entre %d y %d caracteres.', $minLength, $maxLength));
    }
}
