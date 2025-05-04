<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

interface QueryBuilder
{
    public function build(array &$params): string;
}
