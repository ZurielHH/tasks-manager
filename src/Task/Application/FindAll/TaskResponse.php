<?php

declare(strict_types=1);

namespace App\Task\Application\FindAll;

use App\Shared\Application\AuditTimestampsResponse;
use JsonSerializable;

final readonly class TaskResponse implements JsonSerializable
{
    public function __construct(
        private string $id,
        private string $title,
        private string $priority,
        private bool $completed,
        private string $description,
        private string $dueDate,
        private AuditTimestampsResponse $timestampsResponse,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'priority' => $this->priority(),
            'completed' => $this->completed,
            'description' => $this->description,
            'dueDate' => $this->dueDate,
            'createdAt' => $this->timestampsResponse->createdAt(),
            'updatedAt' => $this->timestampsResponse->updatedAt(),
        ];
    }

    private function priority(): string
    {
        return strtoupper($this->priority);
    }
}
