<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidUuid;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

abstract class Uuid implements Stringable
{
    private string $value;

    final public static function create(string $uuid): static
    {
        return new static($uuid);
    }

    private function __construct(string $uuid)
    {
        $this->setUuid($uuid);
    }

    private function setUuid(string $value): void
    {
        $this->ensureIsValidUuid($value);

        $this->value = $value;
    }

    private function ensureIsValidUuid(string $uuid): void
    {
        if (!RamseyUuid::isValid($uuid)) {
            throw InvalidUuid::createFromInvalidValue($uuid);
        }
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
