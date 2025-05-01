<?php

declare(strict_types=1);

namespace App\Entities\Repositories;

use App\Entities\User;

interface UserRepository
{
    public function create(User $user): User;
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?array;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
