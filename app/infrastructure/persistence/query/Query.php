<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class Query
{
    private string $sql;
    private array $params = [];

    public function __construct(string $sql, array $params = [])
    {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
