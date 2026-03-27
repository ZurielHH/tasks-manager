<?php

declare(strict_types=1);

use Doctrine\ORM\Proxy\ProxyFactory;

$isDevMode = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] !== 'production';
$rootPath = dirname(__DIR__, 2);

return [
    'settings' => [
        'app' => [
            'name' => 'Task Manager',
        ],
        'doctrine' => [
            'dev_mode' => $isDevMode,
            'mapping_paths' => [
                dirname(__DIR__) . '/Task/Infrastructure/Persistence/Doctrine/Mapping',
                dirname(__DIR__) . '/Shared/Infrastructure/Persistence/Doctrine/Mapping',
            ],
            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => $rootPath . '/var/data/tasks.db',
            ],
            'proxy_dir' => $rootPath . '/var/doctrine/proxies',
            'proxy_namespace' => 'DoctrineProxies',
            'proxy_auto_generate' => $isDevMode
                ? ProxyFactory::AUTOGENERATE_EVAL
                : ProxyFactory::AUTOGENERATE_NEVER,
        ],
    ],
];
