<?php

declare(strict_types=1);

namespace Castroitalo\Core\Database;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Manage database connection
 *
 * @package Castroitalo\Core\Database
 */
class Connection
{
    /**
     * Database connection
     *
     * @var null|PDO
     */
    private static ?PDO $connection = null;

    /**
     * Database connection settings for PHP
     */
    private const array CONNECTION_SETTINGS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false
    ];

    /**
     * Prevent multi class instances
     *
     * @return void
     */
    private function __construct() {}

    /**
     * Prevent multi class cloning
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Create a database connection based on .env info
     *
     * @return PDO
     * @throws RuntimeException
     */
    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $requiredEnvVars = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'];

                foreach ($requiredEnvVars as $var) {
                    if (empty($_ENV[$var])) {
                        throw new RuntimeException("Missing required database configuration: {$var}");
                    }
                }

                $dsn = sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
                    $_ENV['DB_HOST'],
                    $_ENV['DB_PORT'],
                    $_ENV['DB_NAME']
                );
                self::$connection = new PDO(
                    $dsn,
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    self::CONNECTION_SETTINGS
                );
            } catch (PDOException $e) {
                error_log(sprintf(
                    'Database connection failed in %s: %s',
                    __METHOD__,
                    $e->getMessage()
                ));
                throw new RuntimeException('Database connection failed', 0, $e);
            }
        }

        return self::$connection;
    }

    /**
     * Disconnect PHP from database
     *
     * @return void
     */
    public static function disconnect(): void
    {
        self::$connection = null;
    }

    /**
     * Check if PHP is connected to database
     *
     * @return bool
     */
    public static function isConnected(): bool
    {
        return self::$connection !== null;
    }
}
