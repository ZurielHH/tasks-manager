<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\Value_Object\TaskIdentifier;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class TaskIdentifierType extends GuidType
{
    public const string NAME = 'task_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string | null
    {
        return null !== $value ? (string) $value : null;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TaskIdentifier | null
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof TaskIdentifier ? $value : TaskIdentifier::create((string) $value);
    }

    /**
     * Evita que Doctrine intente convertir el valor de nuevo en consultas
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
