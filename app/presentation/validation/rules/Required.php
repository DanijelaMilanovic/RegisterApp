<?php

declare(strict_types=1);

namespace App\Presentation\Validation\Rules;

use App\Presentation\Validation\Rule;

class Required implements Rule
{
    public function __construct(private string $field) {}

    public function validate(mixed $data): string
    {
        return isset($data[$this->field])
            ? ''
            : "The {$this->field} field must not be empty.";
    }
}
