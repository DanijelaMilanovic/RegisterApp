<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\User;

interface UserRepository
{
    public function create(User $user): User;
    public function findByEmail(string $email): ?User;
}
