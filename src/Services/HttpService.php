<?php

declare(strict_types=1);

namespace Castroitalo\Services;

/**
 * HTTP services
 *
 * @package Castroitalo\Http
 */
class HttpService
{
    /**
     * Get HTTP method
     *
     * @return string
     */
    static public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get requested route
     *
     * @return string
     */
    static public function getRoute(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
