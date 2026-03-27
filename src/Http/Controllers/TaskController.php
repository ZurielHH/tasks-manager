<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Http\Responses\ResponseTrait;
use App\Http\StatusCode;
use App\Task\Domain\TaskRepository;
use Psr\Http\Message\{ServerRequestInterface as Request, ResponseInterface as Response};
use Slim\Exception\HttpBadRequestException;

abstract class TaskController
{
    use ResponseTrait;

    public function __construct(protected readonly TaskRepository $repository)
    {
    }

    protected function getId(Request $request): string
    {
        $id = $request->getAttribute('id');

        if (!is_string($id)) {
            throw new HttpBadRequestException($request, 'Parámetros incompletos.');
        }

        return $id;
    }

    protected function getParsedBody(Request $request): array
    {
        $body = $request->getParsedBody();

        return is_array($body) ? $body : [];
    }
}
