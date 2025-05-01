<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Validators\ValidatorBuilder;

class RegisterUserRequestValidator implements RequestValidatorInterface
{
    public function validate(array $data): array
    {
        $validator = ValidatorBuilder::create()
            ->required('email')
            ->emailFormat('email')
            ->emailExists('email', 'user')
            ->required('password')
            ->minLength('password', 8)
            ->required('password2')
            ->minLength('password2', 8)
            ->missmatchPassword('password', 'password2')
            ->build();

        $errors = $validator->validate($data);
        
        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }
    }
}
