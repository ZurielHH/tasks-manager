<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DateTimeImmutable;

final class AuditTimestamps
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable | null $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = null;
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable | null
    {
        return $this->updatedAt;
    }
}
