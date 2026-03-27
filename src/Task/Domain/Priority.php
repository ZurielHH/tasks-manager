<?php

declare(strict_types=1);

namespace App\Task\Domain;

use App\Task\Domain\Exception\InvalidTaskPriority;

enum Priority: string
{
    case LOW = 'Baja';
    case MEDIUM = 'Media';
    case HIGH = 'Alta';

    public static function createFromString(string $priority): self
    {
        $priority = strtolower($priority)
                |> ucfirst(...);

        return match ($priority) {
            self::LOW->value => self::LOW,
            self::MEDIUM->value => self::MEDIUM,
            self::HIGH->value => self::HIGH,
            default => throw InvalidTaskPriority::createFromInvalidValue($priority),
        };
    }
}
