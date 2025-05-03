<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class InsertBuilder implements QueryBuilderInterface
{
    private string $table;
    private array  $data;

    public function __construct(string $table, array  $data)
    {
        $this->table = $table;
        $this->data  = $data;
    }

    public function build(array &$params): string
    {
        if (empty($this->data)) {
            return '';
        }

        $cols = [];
        $vals = [];
        $i    = 0;

        foreach ($this->data as $col => $val) {
            $cols[] = $col;

            if ($val instanceof Expression) {
                $vals[] = (string)$val;
            } else {
                $param        = ':p' . $i++;
                $vals[]       = $param;
                $params[$param] = $val;
            }
        }

        return sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $cols),
            implode(', ', $vals)
        );
    }
}
