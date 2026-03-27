<?php

declare(strict_types=1);

use App\Http\Controllers\{CreateTasksController,
    GetAllTasksController,
    GetTaskController,
    MarkCompletedTasksController,
    UpdateTasksController};
use Psr\Http\Message\{RequestInterface as Request, ResponseInterface as Response};
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response): Response {
        $response->getBody()->write('Welcome to the Task API 🤖!');

        return $response;
    });

    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->get('/tasks', GetAllTasksController::class);
        $group->get('/tasks/{id}', GetTaskController::class);
        $group->post('/tasks', CreateTasksController::class);
        $group->put('/tasks/{id}', UpdateTasksController::class);
        $group->patch('/tasks/{id}/complete', MarkCompletedTasksController::class);
    });
};
