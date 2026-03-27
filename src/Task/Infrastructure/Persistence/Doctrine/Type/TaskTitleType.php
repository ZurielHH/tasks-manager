<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\Value_Object\TaskTitle;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class TaskTitleType extends StringType
{
    public const string NAME = 'task_title';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = TaskTitle::$maxLength;

        return parent::getSQLDeclaration($column, $platform);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return null !== $value ? (string) $value : '';
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TaskTitle | null
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof TaskTitle ? $value : TaskTitle::create((string) $value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
