<?php

declare(strict_types=1);

namespace App\Services\Dtos;

class UserRegisterDto
{
    public string $email;
    public string $password;
    public string $password2;
    public string $ip;

    public function __construct(string $email, string $password, string $password2, string $ip)
    {
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;
        $this->ip = $ip;
    }
}
