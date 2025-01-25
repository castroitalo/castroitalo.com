<?php

declare(strict_types=1);

namespace Castroitalo\Services;

/**
 * Session service
 *
 * @package Castroitalo\Services
 */
class SessionService
{
    /**
     * Start a new session only if already doesn't exists one
     *
     * @return void
     */
    static function startSession(): void
    {
        if (session_start() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get a session value by key
     *
     * @param string $key
     * @return mixed
     */
    static function getSessionValue(string $key): mixed
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Get entire session as an object
     *
     * @return object
     */
    static function getSession(): object
    {
        return (object)$_SESSION;
    }

    /**
     * Get session ID
     *
     * @return null|string
     */
    static function getSessionId(): ?string
    {
        if (session_start() === PHP_SESSION_NONE) {
            return null;
        }

        return session_id();
    }

    /**
     * Set/update a session value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    static function setSessionValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete a session key if it exists
     *
     * @param string $key
     * @return null|true
     */
    static function deleteSessionValue(string $key): ?true
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);

            return true;
        }

        return null;
    }

    /**
     * Clean session
     *
     * @return void
     */
    static function cleanSession(): void
    {
        $_SESSION = [];
    }

    /**
     * Restart session
     *
     * @return void
     */
    static function restartSession(): void
    {
        if (session_start() === PHP_SESSION_NONE) {
            self::startSession();

            return;
        }

        session_regenerate_id();
    }
}
