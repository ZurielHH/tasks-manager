<?php

declare(strict_types=1);

namespace App\Task\Infrastructure;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use App\Task\Domain\{Task, TaskRepository};
use App\Task\Domain\Value_Object\TaskIdentifier;

final readonly class DoctrineTaskRepository implements TaskRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @throws OptimisticLockException | ORMException
     */
    public function findById(TaskIdentifier $id): Task|null
    {
        return $this->entityManager->find(Task::class, ['id' => (string) $id]);
    }

    /**
     * @throws OptimisticLockException | ORMException
     */
    public function persist(Task $task): void
    {
        $this->entityManager->persist($task);

        $this->entityManager->flush();
    }
}
