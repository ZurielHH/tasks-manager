<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Stringable;

abstract class StringValueObject implements Stringable
{
    private string | null $value;

    public function isEmpty(string $value): bool
    {
        return trim($value) === '';
    }

    protected function hasAValidLength(string $value, int $minLength, int $maxLength): bool
    {
        $length = $this->getValueLength($value);

        return ($this->isGreaterThanOrEqualTo($length, $minLength) && $this->isLessThanOrEqualTo($length, $maxLength));
    }

    protected function isGreaterThanOrEqualTo(int $length, int $expected): bool
    {
        return $length >= $expected;
    }

    protected function isLessThanOrEqualTo(int $length, int $expected): bool
    {
        return $length <= $expected;
    }

    protected function getValueLength(string $value): int
    {
        return mb_strlen(trim($value));
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    protected function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value ?? '';
    }
}
