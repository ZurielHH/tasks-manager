<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use RuntimeException;

final class InvalidUuid extends RuntimeException
{
    public static function createFromInvalidValue(string $uuid): self
    {
        return new self(sprintf('No es un valor válido: %s.', $uuid));
    }
}
