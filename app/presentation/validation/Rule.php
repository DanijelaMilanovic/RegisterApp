<?php

declare(strict_types=1);

namespace App\Presentation\Validation;

interface Rule {
    public function validate(mixed $data): string;
}
