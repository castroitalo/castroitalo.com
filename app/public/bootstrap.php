<?php

declare(strict_types=1);

use Castroitalo\Core\Database\Connection;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

require_once __DIR__ . '/../vendor/autoload.php';

// Error reporting configuration
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-errors.log');

// Timezone configuration
date_default_timezone_set('UTC');

try {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));

    $dotenv->load();

    // Validate required environment variables
    $dotenv->required([
        'DB_HOST',
        'DB_NAME',
        'DB_USER',
        'DB_PORT',
        'APP_ENV'
    ])->notEmpty();
    $dotenv->required('APP_ENV')
        ->allowedValues(['development', 'production']);
} catch (InvalidPathException $e) {
    die('Could not find .env file. Please create one from .env.example');
} catch (Exception $e) {
    die('Failed to load environment variables: ' . $e->getMessage());
}

// Set error reporting based on environment
if ($_ENV['APP_ENV'] === 'development') {
    ini_set('display_errors', '1');
}

// Security settings
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
ini_set('session.use_strict_mode', '1');

// Connect to database
try {
    Connection::connect();
} catch (Exception $ex) {
    error_log("[DB Connection Failed] " . $ex->getMessage());

    if ($_ENV['APP_ENV'] === 'production') {
        die('Service temporarily unavailable. Please try again later.');
    } else {
        die('Database connection failed: ' . $ex->getMessage());
    }
}

// Register shutdown function for fatal errors
// register_shutdown_function(function () {
//     $error = error_get_last();

//     if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
//         error_log("Fatal error: {$error['message']} in {$error['file']} on line {$error['line']}");

//         if ($_ENV['APP_ENV'] === 'production') {
//             header('HTTP/1.1 500 Internal Server Error');
//             readfile(__DIR__ . '/../views/errors/500.html');
//             exit;
//         }
//     }
// });
