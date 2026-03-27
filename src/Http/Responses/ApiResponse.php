<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\StatusCode;
use JsonSerializable;

final readonly class ApiResponse implements JsonSerializable
{
    public function __construct(
        private StatusCode $status = StatusCode::OK,
        private array | object | null $data = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        $payload = [
            'code' => $this->status->value,
        ];

        if (null !== $this->data) {
            $payload['data'] = $this->data;
        }

        return $payload;
    }
}
