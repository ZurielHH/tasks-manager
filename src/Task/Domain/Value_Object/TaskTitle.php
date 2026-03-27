<?php

declare(strict_types=1);

namespace App\Task\Domain\Value_Object;

use App\Shared\Domain\ValueObject\StringValueObject;
use App\Task\Domain\Exception\InvalidTaskTitle;

final class TaskTitle extends StringValueObject
{
    private static int $minLength = 2;
    public static int $maxLength = 100;

    public static function create(string $title): self
    {
        return new self($title);
    }

    private function __construct(string $title)
    {
        $this->setTitle($title);
    }

    private function setTitle(string $title): void
    {
        if ($this->isEmpty($title)) {
            throw InvalidTaskTitle::createFromEmpty();
        }

        $this->ensureThatTitleIsValid($title);

        $this->setValue($title);
    }

    private function ensureThatTitleIsValid(string $title): void
    {
        if (!$this->hasAValidLength($title, self::$minLength, self::$maxLength)) {
            throw InvalidTaskTitle::createFromInvalidLength(self::$minLength, self::$maxLength);
        }
    }
}
