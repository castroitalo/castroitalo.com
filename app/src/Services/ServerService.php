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
    public static function isLocalhost(): bool
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
    public static function setApiResponse(int $responseCode, string $responseMessage, ?array $responseData = null): void
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
    public static function redirectTo(string $route): void
    {
        header('Location: ' . $route);
    }

    /**
     * Gets application current protocol
     *
     * @return string
     */
    public static function getProtocol(): string
    {
        if (
            isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            return 'https://';
        }

        return 'http://';
    }

    /**
     * Get URL
     *
     * @param null|string $url
     * @return void
     */
    public static function getUrl(?string $url = null): string
    {
        return self::getProtocol() . $_SERVER['HTTP_HOST'] . $url ?? '';
    }
}
