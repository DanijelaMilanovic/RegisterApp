<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

interface QueryBuilderInterface
{
    public function build(array &$params): string;
}
