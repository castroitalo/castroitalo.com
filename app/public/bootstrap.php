<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Castroitalo\Database\Connection;
use Dotenv\Dotenv;

// Start dotenv
$dotenv = Dotenv::createImmutable(CONF_APP_ROOT_DIR);

$dotenv->load();

// Start database connection
$databaseConnection = null;
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];

if ($host === 'localhost' || $host === '127.0.0.1') {
    $databaseConnection = Connection::connect(
        $_ENV['DB_DEV_NAME'],
        $_ENV['DB_DEV_HOST'],
        $_ENV['DB_DEV_PORT'],
        $_ENV['DB_DEV_USER'],
        $_ENV['DB_DEV_PASSWORD'],
    );
} else {
    $databaseConnection = Connection::connect(
        $_ENV['DB_PROD_NAME'],
        $_ENV['DB_PROD_HOST'],
        $_ENV['DB_PROD_PORT'],
        $_ENV['DB_PROD_USER'],
        $_ENV['DB_PROD_PASSWORD'],
    );
}
