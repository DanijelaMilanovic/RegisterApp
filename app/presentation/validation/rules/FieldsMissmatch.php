<?php

declare(strict_types=1);

namespace App\Presentation\Validation\Rules;

use App\Presentation\Validation\Rule;

class FieldsMissmatch implements Rule
{
    private string $field;
    private string $field2;
    public function __construct(string $field, string $field2)
    {
        $this->field = $field;
        $this->field2 = $field2;
    }

    public function validate(mixed $data): string
    {
        return isset($data[$this->field], $data[$this->field2]) && $data[$this->field] === $data[$this->field2]
            ? ''
            : "The {$this->field} and {$this->field2} fields do not match.";
    }
}
