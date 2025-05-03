<?php

declare(strict_types=1);

namespace App\Presentation\Validation;

use App\Shared\Exceptions\ValidationException;

class RegisterUserRequestValidator implements RequestValidator
{
    public function validate(array $data) :void
    {
        $validator = ValidatorBuilder::create()
            ->required('email')
            ->emailFormat('email')
            ->required('password')
            ->minLength('password', 8)
            ->required('password2')
            ->minLength('password2', 8)
            ->fieldsMissmatch('password', 'password2')
            ->build();

        $errors = $validator->validate($data);
        
        if (!empty($errors)) {
            throw new ValidationException( $errors);
        }
    }
}
