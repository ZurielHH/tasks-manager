<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineEntityManagerFactory;
use App\Task\Application\FindAll\AllTasks;
use App\Task\Domain\Service\GenerateTaskIdentifier;
use App\Task\Domain\TaskRepository;
use App\Task\Infrastructure\{DoctrineAllTasks, DoctrineTaskRepository};
use App\Task\Infrastructure\Identity\UuidGenerateTaskIdentifier;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder();

$builder->addDefinitions([
    'settings' => function () {
        $settings = require __DIR__ . '/settings.php';

        return $settings['settings'] ?? [];
    },
    EntityManagerInterface::class => function (ContainerInterface $container): EntityManagerInterface {
        $settings = $container->get('settings');

        return DoctrineEntityManagerFactory::create($settings['doctrine'] ?? []);
    },
    GenerateTaskIdentifier::class => fn () => new UuidGenerateTaskIdentifier(),
    TaskRepository::class => fn (ContainerInterface $container) =>
        new DoctrineTaskRepository($container->get(EntityManagerInterface::class)),
    AllTasks::class => fn (ContainerInterface $container) => new DoctrineAllTasks($container->get(EntityManagerInterface::class)),
]);

return $builder->build();
