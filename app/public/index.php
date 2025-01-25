<?php

declare(strict_types=1);

use Castroitalo\Controllers\Errors\PageNotFoundController;
use Castroitalo\Controllers\Errors\UnexpectedErrorController;
use Castroitalo\Controllers\Home\HomeController;
use Castroitalo\Services\HttpService;
use Castroitalo\Services\ServerService;

require_once __DIR__ . '/bootstrap.php';

ob_start();

try {
    // Define routes
    $router->add(
        CONF_HTTP_GET,
        CONF_ROUTES_HOME,
        [HomeController::class, 'home']
    );

    // Define default routes
    $router->add(
        CONF_HTTP_GET,
        CONF_ROUTES_PAGE_NOT_FOUND,
        [PageNotFoundController::class, 'pageNotFound']
    );
    $router->add(
        CONF_HTTP_GET,
        CONF_ROUTES_UNEXPECTED_ERROR,
        [UnexpectedErrorController::class, 'unexpectedError']
    );

    $router->handleRequest(HttpService::getMethod(), HttpService::getRoute());
} catch (Exception $ex) {
    // Show error if it is localhost
    if (ServerService::isLocalhost()) {
        var_dump($ex->getMessage());
        exit();
    }

    error_log($ex->getMessage());
    ServerService::redirectTo(CONF_ROUTES_UNEXPECTED_ERROR);
    exit();
}


ob_end_flush();
