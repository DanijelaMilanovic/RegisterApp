<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class QueryDirector
{
    private array $parts = [];
    public function __construct(array $parts) {
        $this->parts = $parts;
    }

    public function build(): Query
    {
        $params = [];
        $sql    = '';

        foreach ($this->parts as $part) {
            $sql .= $part->build($params);
        }

        return new Query($sql, $params);
    }
}
