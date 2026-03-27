<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Identity;

use App\Task\Domain\Service\GenerateTaskIdentifier;
use App\Task\Domain\Value_Object\TaskIdentifier;
use Ramsey\Uuid\Uuid;

final class UuidGenerateTaskIdentifier implements GenerateTaskIdentifier
{
    public function create(): TaskIdentifier
    {
        return TaskIdentifier::create(Uuid::uuid7()->toString());
    }
}
