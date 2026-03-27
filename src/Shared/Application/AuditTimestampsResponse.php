<?php

declare(strict_types=1);

namespace App\Shared\Application;

final readonly class AuditTimestampsResponse
{
    public function __construct(private string $createdAt, private string $updatedAt)
    {
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
