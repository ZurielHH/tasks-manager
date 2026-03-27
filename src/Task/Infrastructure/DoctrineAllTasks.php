<?php

declare(strict_types=1);

namespace App\Task\Infrastructure;

use App\Task\Application\FindAll\AllTasks;
use Doctrine\DBAL\{Connection, Exception};
use Doctrine\ORM\EntityManager;

final class DoctrineAllTasks implements AllTasks
{
    private static string $tableName = 'tasks';
    private readonly Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    /**
     * @throws Exception
     */
    public function read(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select(
                "id",
                "title",
                "priority",
                "completed",
                "IFNULL(description, '') AS description",
                "IFNULL(due_date, '') AS dueDate",
                "created_at AS createdAt",
                "IFNULL(updated_at, '') AS updatedAt"
            )
            ->from(self::$tableName);

        return $queryBuilder->executeQuery()->fetchAllAssociative();
    }
}
