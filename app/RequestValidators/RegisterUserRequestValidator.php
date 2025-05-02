<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Validators\ValidatorBuilder;

class RegisterUserRequestValidator implements RequestValidatorInterface
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
            ->fieldsPassword('password', 'password2')
            ->build();

        $errors = $validator->validate($data);
        
        if (!empty($errors)) {
            throw new ValidationException( $errors);
        }
    }
}
