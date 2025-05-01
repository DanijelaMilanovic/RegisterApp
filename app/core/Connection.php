<?php

declare(strict_types=1);

namespace App\Core;

interface Connection
{
    public function prepare(string $sql): \PDOStatement;
}
