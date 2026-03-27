<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Task\Application\MarkTaskCompleted\MarkTaskCompletedHandler;
use App\Task\Application\TaskQuery;
use Psr\Http\Message\{ResponseInterface as Response, ServerRequestInterface as Request};

final class MarkCompletedTasksController extends TaskController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $id = $this->getId($request);

        $markTaskCompletedHandler = new MarkTaskCompletedHandler($this->repository);

        $query = new TaskQuery($id);

        ($markTaskCompletedHandler)($query);

        return $this->json($response, StatusCode::NO_CONTENT);
    }
}
