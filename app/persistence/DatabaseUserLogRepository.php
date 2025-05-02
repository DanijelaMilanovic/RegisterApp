<?php

declare(strict_types=1);

namespace App\Persistence;

use DateTime;
use PDO;
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

        $id = (int)$this->pdo->lastInsertId();

        return $this->findById($id);
    }

    public function findById(int $id): ?UserLog
    {
        $sql = "SELECT * FROM user_log WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new UserLog(
            (int)$row['id'],
            $row['action'],
            new DateTime($row['log_time']),
            (int)$row['user_id']
        );
    }
}
