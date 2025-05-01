<?php

declare(strict_types=1);

namespace App\Validators;

class ValidatorCollection
{
    private array $rules = [];

    public function __construct(array $rules) {
        $this->rules = $rules;
    }

    public function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules as $rule) {

            if ($msg = $rule->validate($data)) {
                $errors[] = $msg;
            }
        }

        return $errors;
    }
}
