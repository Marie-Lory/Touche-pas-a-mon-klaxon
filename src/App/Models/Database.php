<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

/**
 * Database connection helper (singleton).
 */
class Database
{
    /** @var PDO|null */
    private static ?PDO $connection = null;

    /**
     * Returns a PDO connection instance.
     *
     * @return PDO
     * @throws PDOException on failure
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $dbname = getenv('DB_NAME') ?: 'covoiturage';
            $username = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASS') ?: '';

            try {
                self::$connection = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
                
            } catch (PDOException $e) {
                // en dev tu peux throw; en prod faire un logger.
                throw $e;
            }
        }

        return self::$connection;
    }
}