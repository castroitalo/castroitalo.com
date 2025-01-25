<?php

declare(strict_types=1);

use Castroitalo\Services\ServerService;
use Castroitalo\Services\SessionService;

require_once __DIR__ . '/bootstrap.php';

ob_start();

try {
} catch (Exception $ex) {
    // Show error if it is localhost
    if (ServerService::isLocalhost()) {
        var_dump($ex->getMessage());
        exit();
    }

    error_log($ex->getMessage());
    ServerService::setApiResponse(500, 'something went wrong');
}


ob_end_flush();
