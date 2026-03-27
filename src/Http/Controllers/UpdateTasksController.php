<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Task\Application\Update\UpdateTaskCommand;
use App\Task\Application\Update\UpdateTaskHandler;
use Psr\Http\Message\{ResponseInterface as Response, ServerRequestInterface as Request};
use Slim\Exception\HttpBadRequestException;

final class UpdateTasksController extends TaskController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $id = $this->getId($request);

        $command = $this->createCommandFromRequest($id, $request->getParsedBody());

        $updateTaskHandler = new UpdateTaskHandler($this->repository);

        ($updateTaskHandler)($command);

        return $this->json($response, StatusCode::NO_CONTENT);
    }

    private function createCommandFromRequest(string $id, array $data): UpdateTaskCommand
    {
        return new UpdateTaskCommand(
            $id,
            $data['title'] ?? '',
            $data['priority'] ?? '',
            $data['description'] ?? null,
            $data['dueDate'] ?? null
        );
    }
}
