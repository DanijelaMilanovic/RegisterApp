<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\User;

interface UserRepository
{
    public function create(User $user): User;
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function update(int $id, User $user): bool;
    public function delete(int $id): bool;
}
