<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class WhereBuilder implements QueryBuilder
{
    private array $conditions = [];

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    public function build(array &$params): string
    {
        if (empty($this->conditions)) {
            return '';
        }

        $clauses = [];
        foreach ($this->conditions as $i => $cond) {
            if (is_string($cond) || $cond instanceof Expression) {
                $clauses[] = (string)$cond;
            } elseif (is_array($cond)) {
                foreach ($cond as $col => $val) {
                    $param = ":w{$i}_{$col}";
                    $clauses[] = "$col = $param";
                    $params[$param] = $val;
                }
            }
        }

        return ' WHERE ' . implode(' AND ', $clauses);
    }
}
