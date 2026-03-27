<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Task\Application\Create\CreateTaskHandler;
use App\Task\Application\TaskCommand;
use DateMalformedStringException;
use Ramsey\Uuid\Uuid;
use App\Task\Domain\{Task, TaskRepository};
use App\Task\Domain\Service\GenerateTaskIdentifier;
use App\Task\Domain\Value_Object\{TaskDueDate, TaskIdentifier};
use PHPUnit\Framework\TestCase;

final class CreateTaskTest extends TestCase
{
    private TaskRepository $repository;
    private GenerateTaskIdentifier $generateTaskIdentifier;
    private CreateTaskHandler $createTaskHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(TaskRepository::class);

        $this->generateTaskIdentifier = $this->createMock(GenerateTaskIdentifier::class);

        $this->createTaskHandler = new CreateTaskHandler($this->repository, $this->generateTaskIdentifier);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testShouldCreateANewTask(): void
    {
        $this->repository->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Task::class));

        $this->generateTaskIdentifier->expects($this->once())
            ->method('create')
            ->willReturn(TaskIdentifier::create(Uuid::uuid7()->toString()));

        $dueDate = (string) TaskDueDate::now()->addDays(1);

        $command = new TaskCommand('Task 1', 'media', null, $dueDate);

        ($this->createTaskHandler)($command);
    }
}
