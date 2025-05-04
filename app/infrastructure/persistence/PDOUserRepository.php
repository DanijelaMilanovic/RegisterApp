<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use PDO;
use LogicException;
use App\Domain\User;
use App\Domain\Repository\UserRepository;
use App\Infrastructure\Persistence\PDOConnection;
use App\Infrastructure\Persistence\Query\QueryDirector;
use App\Infrastructure\Persistence\Query\InsertBuilder;
use App\Infrastructure\Persistence\Query\SelectBuilder;
use App\Infrastructure\Persistence\Query\WhereBuilder;

class PDOUserRepository implements UserRepository
{
    private PDOConnection $pdo;

    public function __construct(PDOConnection $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(User $user): User
    {
        $data = [
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ];

        $insertQueryBuilder = new QueryDirector([
            new InsertBuilder('user',$data)]);

        $insertQuery = $insertQueryBuilder->build();
        $stmt = $this->pdo->prepare($insertQuery->getSql());
        $stmt->execute($insertQuery->getParams());
        
        return new User(
            (int)$this->pdo->lastInsertId(),
            $user->getEmail(),
            $user->getPassword()
        );
    }

    public function findByEmail(string $email): ?User
    {   $selectQueryBuilder = new QueryDirector([
            new SelectBuilder('user', ['*']),
            new WhereBuilder([['email' => $email]])
        ]);

        $selectQuery = $selectQueryBuilder->build();

        $stmt = $this->pdo->prepare($selectQuery->getSql());
        $stmt->execute($selectQuery->getParams());

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            (int)$row['id'],
            $row['email'],
            $row['password']
        );
    }

    public function findById(int $id): ?User
    {
        $selectQueryBuilder = new QueryDirector([
            new SelectBuilder('user', ['*']),
            new WhereBuilder([['id' => $id]])
        ]);

        $selectQuery = $selectQueryBuilder->build();

        $stmt = $this->pdo->prepare($selectQuery->getSql());
        $stmt->execute($selectQuery->getParams());

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new User(
            (int)$this->pdo->lastInsertId(),
            $row->getEmail(),
            $row->getPassword()
        );
    }

    public function update(int $id, User $user): bool
    {
        throw new LogicException('UserRepository::update() is not implemented.');
    }

    public function delete(int $id): bool
    {
        throw new LogicException('UserRepository::delete() is not implemented.');
    }
}
