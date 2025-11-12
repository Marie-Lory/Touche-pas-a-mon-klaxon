<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * User model.
 *
 * @psalm-type UserRow = array{
 *   id:int,
 *   nom:string|null,
 *   prenom:string|null,
 *   email:string|null,
 *   role:string|null,
 *   phone:string|null
 * }
 */
class User
{
    private PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        
        $this->pdo = $pdo;
    }

    /**
     * Find user by email.
     *
     * @param string $email
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    /**
     * Find user by id.
     *
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }
}