<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Task\Application\Find\FindTaskHandler;
use App\Task\Application\TaskQuery;
use Psr\Http\Message\{ServerRequestInterface as Request, ResponseInterface as Response};
use Slim\Exception\HttpBadRequestException;

final class GetTaskController extends TaskController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $id = $this->getId($request);

        $query = new TaskQuery($id);

        $findTask = new FindTaskHandler($this->repository);

        $task = $findTask($query);

        return $this->json($response, StatusCode::OK, $task);
    }
}
