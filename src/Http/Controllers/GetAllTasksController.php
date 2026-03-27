<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\ResponseTrait;
use App\Http\StatusCode;
use App\Task\Application\FindAll\AllTasks;
use App\Task\Application\FindAll\FindAllTasksHandler;
use App\Task\Application\FindAll\TaskMapper;
use Psr\Http\Message\{RequestInterface as Request, ResponseInterface as Response};

final readonly class GetAllTasksController
{
    use ResponseTrait;

    public function __construct(private AllTasks $allTasks)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $getAllTasksHandler = new FindAllTasksHandler($this->allTasks, new TaskMapper());

        $tasks = $getAllTasksHandler();

        return $this->json($response, StatusCode::OK, $tasks);
    }
}
