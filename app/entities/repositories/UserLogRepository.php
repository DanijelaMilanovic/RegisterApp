<?php

declare(strict_types=1);

namespace App\Entities\Repositories;

use App\Entities\UserLog;

interface UserLogRepository
{
    public function create(UserLog $userLog): UserLog;
    public function findById(int $id): ?UserLog;
}
