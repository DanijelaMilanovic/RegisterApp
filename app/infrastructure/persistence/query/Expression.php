<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Query;

class Expression
{
   private function __construct(private string $sql)
   {

   }
    public static function raw(string $sql): self
    {
        return new self($sql);
    }
    public function __toString(): string
    {
        return $this->sql;
    }

}
