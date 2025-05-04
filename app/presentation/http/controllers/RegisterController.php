<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Presentation\Validation\RegisterUserRequestValidator;
use App\Presentation\Http\JsonResponse;
use App\Services\UserService;
use App\Services\Dtos\UserRegisterDto;

class RegisterController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(array $request): void
    {
        $requestValidator = new RegisterUserRequestValidator();
        $requestValidator->validate($request);

        $userRegisterDto = new UserRegisterDto(
            $request['email'],
            $request['password'],
            $request['password2'],
            $_SERVER['REMOTE_ADDR']
        );
            
        $result = $this -> userService -> registerUser($userRegisterDto);

        JsonResponse::ok($result);
    }
}
