<?php

declare(strict_types=1);

namespace Castroitalo\Services;

/**
 * Common server functions
 *
 * @package Castroitalo\Services
 */
class ServerService
{
    /**
     * Check if app is running localhost
     *
     * @return bool
     */
    static function isLocalhost(): bool
    {
        if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            return true;
        }

        return false;
    }

    /**
     * Set a new API response body
     *
     * @param int $responseCode
     * @param string $responseMessage
     * @param null|array $responseData
     * @return void
     */
    static function setApiResponse(int $responseCode, string $responseMessage, ?array $responseData = null): void
    {
        http_response_code($responseCode);
        header('Content-type: application/json');

        $apiResponseBody = [];
        $apiResponseBody['message'] = $responseMessage;

        if (!is_null($responseCode)) {
            $apiResponseBody['data'] = $responseData;
        }

        echo json_encode($apiResponseBody);
        exit();
    }

    /**
     * Redirect to
     *
     * @param string $route
     * @return void
     */
    static function redirectTo(string $route): void
    {
        header('Location: ' . $route);
    }
}
