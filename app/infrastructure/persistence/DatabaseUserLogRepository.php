<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use DateTime;
use PDO;
use App\Domain\UserLog;
use App\Domain\Repository\UserLogRepository;
use App\Infrastructure\Persistence\PDOConnection;
use App\Infrastructure\Persistence\Query\QueryDirector;
use App\Infrastructure\Persistence\Query\Expression;
use App\Infrastructure\Persistence\Query\InsertBuilder;
use App\Infrastructure\Persistence\Query\SelectBuilder;
use App\Infrastructure\Persistence\Query\WhereBuilder;

class DatabaseUserLogRepository implements UserLogRepository
{
    private PDOConnection $pdo;

    public function __construct(PDOConnection $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(UserLog $userLog): UserLog
    {
        $data = [
            'action' => $userLog->getAction(),
            'user_id' => $userLog->getUserId(),
            'log_time' => Expression::raw('NOW()')
        ];

        $insertQueryBuilder = new QueryDirector([
            new InsertBuilder('user_log',$data)]);

        $insertQuery = $insertQueryBuilder->build();

        $stmt = $this->pdo->prepare($insertQuery->getSql());
        $stmt->execute($insertQuery->getParams());

        $id = (int)$this->pdo->lastInsertId();

        return $this->findById($id);
    }

    public function findById(int $id): ?UserLog
    {
        $selectQueryBuilder = new QueryDirector([
                        new SelectBuilder('user_log', ['*']),
                        new WhereBuilder([['id' => $id]])]);

        $selectQuery = $selectQueryBuilder->build();

        $stmt = $this->pdo->prepare($selectQuery->getSql());
        $stmt->execute($selectQuery->getParams());

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new UserLog(
            (int)$row['id'],
            $row['action'],
            new DateTime($row['log_time']),
            (int)$row['user_id']);

    }
}
