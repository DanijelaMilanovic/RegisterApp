<?php

declare(strict_types = 1);

namespace App\Validators;

interface RequestValidatorFactoryInterface
{
    public function make(string $class): RequestValidatorInterface;
}
