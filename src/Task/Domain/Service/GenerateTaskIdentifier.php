<?php

declare(strict_types=1);

namespace App\Task\Domain\Service;

use App\Task\Domain\Value_Object\TaskIdentifier;

interface GenerateTaskIdentifier
{
    public function create(): TaskIdentifier;
}
