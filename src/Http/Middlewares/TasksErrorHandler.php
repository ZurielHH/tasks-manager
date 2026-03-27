<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Http\StatusCode;
use App\Shared\Domain\Exception\InvalidUuid;
use App\Task\Domain\Exception\{InvalidTaskDescription,
    InvalidTaskDueDate,
    InvalidTaskPriority,
    InvalidTaskTitle,
    TaskHasAlreadyBeenCompleted,
    TaskNotFound};
use Psr\Http\Message\{ResponseInterface as Response, ServerRequestInterface as Request};
use Slim\Exception\HttpBadRequestException;
use Throwable;

final class TasksErrorHandler
{
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): Response {
        $response = new \Slim\Psr7\Response();

        [$status, $message] = $this->match($exception);

        $payload = [
            'code' => $status,
            'message' => $message,
        ];

        if ($displayErrorDetails) {
            $payload = [
                ...$payload,
                ...[
                    'type' => get_class($exception),
                    'trace' => $exception->getTraceAsString(),
                ],
            ];
        }

        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    private function match(Throwable $exception): array
    {
        return match (true) {
            $exception instanceof InvalidUuid => [StatusCode::BAD_REQUEST->value, $exception->getMessage()],
            $exception instanceof TaskNotFound => [StatusCode::NOT_FOUND->value, $exception->getMessage()],
            $exception instanceof TaskHasAlreadyBeenCompleted,
            $exception instanceof InvalidTaskTitle,
            $exception instanceof InvalidTaskPriority,
            $exception instanceof InvalidTaskDueDate,
            $exception instanceof InvalidTaskDescription
                => [StatusCode::CONFLICT->value, $exception->getMessage()],
            $exception instanceof HttpBadRequestException => [$exception->getCode(), $exception->getMessage()],
            default => [500, 'Internal Server Error'],
        };
    }
}
