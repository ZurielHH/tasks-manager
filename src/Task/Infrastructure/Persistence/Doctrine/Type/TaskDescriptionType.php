<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\Value_Object\TaskDescription;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class TaskDescriptionType extends StringType
{
    public const string NAME = 'task_description';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = TaskDescription::$maxLength;

        return parent::getSQLDeclaration($column, $platform);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string | null
    {
        return null !== $value ? (string) $value : null;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TaskDescription | null
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof TaskDescription ? $value : TaskDescription::create((string) $value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
