<?php

declare(strict_types=1);

namespace App\Validators;

interface Rule {
    public function validate(mixed $data): string;
}
