<?php

declare(strict_types=1);

namespace App\Presentation\Validation\Rules;

use App\Presentation\Validation\Rule;

class MinLength implements Rule
{
    private string $field;
    private int $len;
    
    public function __construct(string $field, int $len)
    {
        $this->field = $field;
        $this->len = $len;
    }

    public function validate(mixed $data): string
    {
        return isset($data[$this->field]) && strlen($data[$this->field]) >= $this->len
            ? ''
            : "The {$this->field} field must be at least {$this->len} characters long.";
    }
}
