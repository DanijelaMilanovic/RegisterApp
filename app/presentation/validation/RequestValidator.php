<?php

declare(strict_types = 1);

namespace App\Presentation\Validation;

interface RequestValidator
{
    public function validate(array $data): void;
}
