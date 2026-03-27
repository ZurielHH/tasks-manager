<?php

declare(strict_types=1);

namespace App\Task\Application\FindAll;

interface AllTasks
{
    public function read(): array;
}
