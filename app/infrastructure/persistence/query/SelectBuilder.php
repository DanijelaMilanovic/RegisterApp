<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class SelectBuilder implements QueryBuilder
{
    private string $table;
    private array $columns = ['*'];

    public function __construct(string $table, array $columns = ['*'])
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function build(array &$params): string
    {
        $cols = implode(', ', $this->columns);
        return "SELECT {$cols} FROM {$this->table}";
    }
}
