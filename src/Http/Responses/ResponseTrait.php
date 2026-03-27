<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\StatusCode;
use Psr\Http\Message\ResponseInterface as Response;

trait ResponseTrait
{
    protected function json(Response $response, StatusCode $status, array | object | null $data = null): Response
    {
        $response = $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus($status->value);

        if (null !== $data) {
            $json = json_encode(new ApiResponse($status, $data), JSON_PRETTY_PRINT);

            $response->getBody()->write($json);
        }

        return $response;
    }
}
