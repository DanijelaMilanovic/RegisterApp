<?php

declare(strict_types=1);

namespace App\Persistence;

use App\Core\PDOConnection;
use App\Entities\Repositories\UserLogRepository;
use App\Entities\UserLog;

class DatabaseUserLogRepository implements UserLogRepository
{
    private PDOConnection $pdo;

    public function __construct(PDOConnection $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(UserLog $userLog): UserLog
    {
        $sql = "INSERT INTO user_log SET `action` = :action, user_id = :user_id, log_time = NOW()";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userLog->getUserId(), 'action' => $userLog->getAction()]);

        $userLog->setId((int)$this->pdo->lastInsertId());
        return $userLog ;
    }
}
