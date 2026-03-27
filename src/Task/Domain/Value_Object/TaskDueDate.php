<?php

declare(strict_types=1);

namespace App\Task\Domain\Value_Object;

use App\Task\Domain\Exception\InvalidTaskDueDate;
use DateMalformedStringException;
use DateTimeImmutable;
use Stringable;

final class TaskDueDate implements Stringable
{
    private static string $format = 'Y-m-d H:i:s';
    private DateTimeImmutable $value;

    public static function now(): self
    {
        return new self(new DateTimeImmutable('now'), true);
    }

    public static function createFromString(string $dueDate, bool $skipValidation): self
    {
        $dueDateCreated = DateTimeImmutable::createFromFormat(self::$format, $dueDate);

        if (!($dueDateCreated instanceof DateTimeImmutable)) {
            throw InvalidTaskDueDate::createFromInvalidFormat();
        }

        return new self($dueDateCreated, $skipValidation);
    }

    private function __construct(DateTimeImmutable $dueDate, bool $skipValidation = false)
    {
        $this->setDueDate($dueDate, $skipValidation);
    }

    private function setDueDate(DateTimeImmutable $dueDate, bool $skipValidation): void
    {
        if (!$skipValidation && $dueDate < new DateTimeImmutable('now')) {
            throw InvalidTaskDueDate::createFromInvalidDueDate();
        }

        $this->value = $dueDate;
    }

    public function isAfter(self $other): bool
    {
        return $this->value() > $other->value();
    }

    public function isBefore(self $other): bool
    {
        return $this->value() < $other->value();
    }

    /**
     * @throws DateMalformedStringException
     */
    public function addDays(int $days): self
    {
        return new self($this->value()->modify(sprintf('+%d days', $days)), true);
    }

    public function equals(self $other): bool
    {
        return $this->format() === $other->format();
    }

    public function __toString(): string
    {
        return $this->format();
    }

    public function format(): string
    {
        return $this->value()->format(self::$format);
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }
}
