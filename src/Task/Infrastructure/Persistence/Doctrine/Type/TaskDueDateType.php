<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\Type;

use App\Task\Domain\Value_Object\TaskDueDate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class TaskDueDateType extends Type
{
    public const string NAME = 'task_due_date';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string | null
    {
        return null !== $value ? (string) $value : null;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): TaskDueDate | null
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof TaskDueDate ? $value : TaskDueDate::createFromString((string) $value, true);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'datetime_immutable';
    }
}
