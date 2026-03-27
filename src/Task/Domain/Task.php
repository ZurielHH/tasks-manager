<?php

declare(strict_types=1);

namespace App\Task\Domain;

use App\Shared\Domain\AuditTimestamps;
use App\Task\Domain\Exception\TaskHasAlreadyBeenCompleted;
use App\Task\Domain\Value_Object\{TaskDescription, TaskDueDate, TaskIdentifier, TaskPriority, TaskTitle};

final class Task
{
    private bool $completed;
    private TaskDescription | null $description;
    private TaskDueDate | null $dueDate;
    private AuditTimestamps $auditTimestamps;

    public static function create(
        TaskIdentifier $id,
        string $title,
        string $priority,
        string | null $description = null,
        string | null $dueDate = null
    ): self {
        $task = new self($id, TaskTitle::create($title), TaskPriority::create($priority));

        $task->addAdditionalProperties($description, $dueDate);

        return $task;
    }

    public function __construct(
        private readonly TaskIdentifier $id,
        private TaskTitle $title,
        private TaskPriority $priority
    ) {
        $this->completed = false;
        $this->description = null;
        $this->dueDate = null;
    }

    public function update(
        string $title,
        string $priority,
        string | null $description = null,
        string | null $dueDate = null
    ): void {
        $this->changeTitle(TaskTitle::create($title));
        $this->changePriority(TaskPriority::create($priority));
        $this->addAdditionalProperties($description, $dueDate);
    }

    private function addAdditionalProperties(string | null $description, string | null $dueDate): void
    {
        $this->addDescription(null !== $description ? TaskDescription::create($description) : null);
        $this->addDueDate(null !== $dueDate ? TaskDueDate::createFromString($dueDate, false) : null);
    }

    public function id(): TaskIdentifier
    {
        return $this->id;
    }

    public function changeTitle(TaskTitle $title): void
    {
        if ($this->title()->equals($title)) {
            return;
        }

        $this->title = $title;
    }

    public function title(): TaskTitle
    {
        return $this->title;
    }

    public function markAsComplete(): void
    {
        if ($this->isComplete()) {
            throw TaskHasAlreadyBeenCompleted::createFromMessage();
        }

        $this->ensureThatIsNotOverdue();

        $this->completed = true;
    }

    private function ensureThatIsNotOverdue(): void
    {
        if ($this->hasADueDate() && $this->dueDate->isBefore(TaskDueDate::now())) {
            throw TaskHasAlreadyBeenCompleted::createFromDueDate();
        }
    }

    public function isComplete(): bool
    {
        return true === $this->complete();
    }

    public function complete(): bool
    {
        return $this->completed;
    }

    public function changePriority(TaskPriority $priority): void
    {
        if ($this->priority()->equals($priority)) {
            return;
        }

        $this->priority = $priority;
    }

    public function priority(): TaskPriority
    {
        return $this->priority;
    }

    public function addDescription(TaskDescription | null $description): void
    {
        if (null === $description) {
            $this->description = null;
        } else {
            $this->assignDescription($description);
        }
    }

    private function assignDescription(TaskDescription $description): void
    {
        if ($this->hasADescription() && $this->description()->equals($description)) {
            return;
        }

        $this->description = $description;
    }

    public function hasADescription(): bool
    {
        return null !== $this->description();
    }

    public function description(): TaskDescription | null
    {
        return $this->description;
    }

    public function addDueDate(TaskDueDate | null $dueDate): void
    {
        if ($this->isComplete()) {
            return;
        }

        $this->changeDueDate($dueDate);
    }

    private function changeDueDate(TaskDueDate | null $dueDate): void
    {
        if (null === $dueDate) {
            $this->dueDate = null;
        } else {
            $this->assignDueDate($dueDate);
        }
    }

    private function assignDueDate(TaskDueDate $dueDate): void
    {
        if ($this->hasADueDate() && $this->dueDate()->equals($dueDate)) {
            return;
        }

        $this->dueDate = $dueDate;
    }

    public function hasADueDate(): bool
    {
        return null !== $this->dueDate();
    }

    public function dueDate(): TaskDueDate | null
    {
        return $this->dueDate;
    }
}
