<?php

declare(strict_types=1);

namespace App\Presentation\Validation;

use App\Presentation\Validation\Rules\EmailFormat;
use App\Presentation\Validation\Rules\FieldsMissmatch;
use App\Presentation\Validation\Rules\Required;
use App\Presentation\Validation\Rules\MinLength;

class ValidatorBuilder
{
    private array $rules = [];

    public static function create(): self
    {
        return new self();
    }

    public function required(string $field): self
    {
        $this->rules[] = new Required($field);
        return $this;
    }
    public function emailFormat(string $field = 'email'): self
    {
        $this->rules[] = new EmailFormat($field);
        return $this;
    }
    public function minLength(string $field, int $len): self
    {
        $this->rules[] = new MinLength($field, $len);
        return $this;
    }
    public function fieldsMissmatch(string $field, string $field2): self
    {
        $this->rules[] = new FieldsMissmatch($field, $field2);
        return $this;
    }

    public function build(): ValidatorCollection
    {
        return new ValidatorCollection($this->rules);
    }
}
