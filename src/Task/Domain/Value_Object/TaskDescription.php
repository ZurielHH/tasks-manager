<?php

declare(strict_types=1);

namespace App\Task\Domain\Value_Object;

use App\Shared\Domain\ValueObject\StringValueObject;
use App\Task\Domain\Exception\InvalidTaskDescription;

final class TaskDescription extends StringValueObject
{
    public static int $maxLength = 500;

    public static function create(string $description): self
    {
        return new self($description);
    }

    private function __construct(string $description)
    {
        $this->setDescription($description);
    }

    private function setDescription(string $description): void
    {
        if ($this->isEmpty($description)) {
            throw InvalidTaskDescription::createFromEmpty();
        }

        $this->ensureThatDescriptionIsValid($description);

        $this->setValue($description);
    }

    private function ensureThatDescriptionIsValid(string $description): void
    {
        $length = $this->getValueLength($description);

        if (!$this->isLessThanOrEqualTo($length, self::$maxLength)) {
            throw InvalidTaskDescription::createFromInvalidLength(self::$maxLength);
        }
    }
}
