<?php

declare(strict_types=1);

namespace App\Persistence;

use App\Entities\Repositories\UserRepository;
use App\Core\PDOConnection;
use App\Entities\User;
use PDO;
use LogicException;

class DatabaseUserRepository implements UserRepository
{
    private PDOConnection $pdo;

    public function __construct(PDOConnection $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(User $user): User
    {
        $sql = 'INSERT INTO user (email, password) VALUES (:email, :password)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $user->getEmail(), 'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT)]);
        
        return new User(
            (int)$this->pdo->lastInsertId(),
            $user->getEmail(),
            $user->getPassword()
        );
    }

    public function findByEmail(string $email): ?User
    {
        $sql = 'SELECT * FROM user WHERE email = :email LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

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
        $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

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
