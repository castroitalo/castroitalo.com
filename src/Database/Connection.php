<?php

declare(strict_types=1);

namespace Castroitalo\Database;

use PDO;
use PDOException;

/**
 * Creates a singleton connection with database
 *
 * @package Castroitalo\Database
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
     * Prevent constructor method
     *
     * @return void
     */
    private function __construct() {}

    /**
     * Prevent clone method
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Get database singleton sonnection
     *
     * @return null|PDO
     */
    public static function connect(
        string $databaseName,
        string $databaseHost,
        string $databasePort,
        string $databaseUser,
        string $databasePassword
    ): ?PDO {
        if (is_null(self::$connection)) {
            try {
                $dsn = 'mysql:host=' . $databaseHost . ';dbname=' . $databaseName . ';charset=utf8;port=' . $databasePort;
                self::$connection = new PDO($dsn, $databaseUser, $databasePassword);

                return self::$connection;
            } catch (PDOException $ex) {
                error_log('Failed connecting with database on ' . __FUNCTION__ . ': ' . $ex->getMessage());

                return self::$connection;
            }
        } else {
            return self::$connection;
        }
    }
}
