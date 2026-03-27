<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\Value_Object\TaskPriority;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class TaskPriorityType extends StringType
{
    public const string NAME = 'task_priority';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 5;

        return parent::getSQLDeclaration($column, $platform);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string | null
    {
        return null !== $value ? (string) $value : null;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TaskPriority | null
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof TaskPriority ? $value : TaskPriority::create((string) $value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
