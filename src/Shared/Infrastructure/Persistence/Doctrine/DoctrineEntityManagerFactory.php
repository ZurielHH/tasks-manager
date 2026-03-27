<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Proxy\ProxyFactory;
use App\Task\Infrastructure\Persistence\Doctrine\Type\{TaskDescriptionType,
    TaskDueDateType,
    TaskIdentifierType,
    TaskPriorityType,
    TaskTitleType};
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\{EntityManager, ORMSetup};
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class DoctrineEntityManagerFactory
{
    private static bool $typesRegistered = false;

    /**
     * @throws Exception
     */
    public static function create(array $config): EntityManager
    {
        self::registerTypes();

        $ormConfig = ORMSetup::createXMLMetadataConfig(
            $config['mapping_paths'] ?? [],
            $config['dev_mode'] ?? true,
            null,
            new ArrayAdapter()
        );

        $ormConfig->setProxyDir($config['proxy_dir'] ?? '');
        $ormConfig->setProxyNamespace($config['proxy_namespace'] ?? '');
        $ormConfig->setAutoGenerateProxyClasses(
            $config['proxy_auto_generate'] ?? ProxyFactory::AUTOGENERATE_EVAL
        );

        $connection = DriverManager::getConnection($config['connection'] ?? [], $ormConfig);

        return new EntityManager($connection, $ormConfig);
    }

    /**
     * @throws Exception
     */
    public static function registerTypes(): void
    {
        if (self::$typesRegistered) {
            return;
        }

        Type::addType(TaskIdentifierType::NAME, TaskIdentifierType::class);
        Type::addType(TaskTitleType::NAME, TaskTitleType::class);
        Type::addType(TaskPriorityType::NAME, TaskPriorityType::class);
        Type::addType(TaskDescriptionType::NAME, TaskDescriptionType::class);
        Type::addType(TaskDueDateType::NAME, TaskDueDateType::class);

        self::$typesRegistered = true;
    }
}
