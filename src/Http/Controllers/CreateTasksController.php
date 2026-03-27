<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Task\Application\Create\CreateTaskHandler;
use App\Task\Application\TaskCommand;
use App\Task\Domain\Service\GenerateTaskIdentifier;
use App\Task\Domain\TaskRepository;
use Psr\Http\Message\{RequestInterface as Request, ResponseInterface as Response};

final class CreateTasksController extends TaskController
{
    public function __construct(
        TaskRepository $repository,
        private readonly GenerateTaskIdentifier $generateTaskIdentifier
    ) {
        parent::__construct($repository);
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $this->getParsedBody($request);

        $createTaskHandler = new CreateTaskHandler(
            $this->repository,
            $this->generateTaskIdentifier
        );

        ($createTaskHandler)($this->createCommandFromRequest($data));

        return $this->json($response, StatusCode::CREATED);
    }

    /**
     * @param array<string, string> $data
     */
    private function createCommandFromRequest(array $data): TaskCommand
    {
        return new TaskCommand(
            $data['title'] ?? '',
            $data['priority'] ?? '',
            $data['description'] ?? null,
            $data['dueDate'] ?? null
        );
    }
}
