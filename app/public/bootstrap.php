<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Castroitalo\Database\Connection;
use Castroitalo\Services\ServerService;
use Castroitalo\Services\SessionService;
use Dotenv\Dotenv;

// Start dotenv
$dotenv = Dotenv::createImmutable(CONF_APP_ROOT_DIR);

$dotenv->load();

// Start database connection
$databaseConnection = null;

if (ServerService::isLocalhost()) {
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

// Validate database connection
if (is_null($databaseConnection)) {
    ServerService::setApiResponse(500, 'failed connecting to database');
}

// Starts session
SessionService::startSession();
