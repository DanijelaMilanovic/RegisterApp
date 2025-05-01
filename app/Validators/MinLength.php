<?php

declare(strict_types=1);

namespace App\Validators;

use App\Validators\Rule;

class MinLength implements Rule
{
    public function __construct(private string $field, private int $len) {}

    public function validate(mixed $data): string
    {
        return isset($data[$this->field]) && strlen($data[$this->field]) >= $this->len
            ? ''
            : "The {$this->field} field must be at least {$this->len} characters long.";
    }
}
