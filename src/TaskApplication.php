<?php

declare(strict_types=1);

use App\Http\Middlewares\TasksErrorHandler;
use DI\Bridge\Slim\Bridge;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

$app = AppFactory::create();

$container = require __DIR__ . '/Config/container.php';

$app = Bridge::create($container);

$app->addRoutingMiddleware();

$app->addBodyParsingMiddleware();

$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    true,
    true
);

$errorMiddleware->setDefaultErrorHandler(new TasksErrorHandler());

$app->add($errorMiddleware);

(require __DIR__ . '/Config/routes.php')($app);

return $app;
