<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\UserLog;

interface UserLogRepository
{
    public function create(UserLog $userLog): UserLog;
    public function findById(int $id): ?UserLog;
}
