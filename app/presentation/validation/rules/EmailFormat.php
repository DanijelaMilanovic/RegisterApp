<?php

declare(strict_types=1);

namespace App\Presentation\Validation\Rules;

use App\Presentation\Validation\Rule;

class EmailFormat implements Rule
{
    private string $field;
    
    public function __construct(string $field = 'email')
    {
        $this->field = $field;
    }

    public function validate(mixed $data): string
    {
        return isset($data[$this->field]) &&
               filter_var($data[$this->field], FILTER_VALIDATE_EMAIL)
            ? ''
            : "Invalid e-mail address format.";
    }
}

