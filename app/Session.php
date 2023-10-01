<?php

namespace App;

class Session
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * keyExists
     *
     * @param  string $key
     * @return bool
     */
    public static function keyExists(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * set
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * unset
     *
     * @param  string $key
     * @return void
     */
    public static function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * get
     *
     * @param  string $key
     * @return ?string
     */
    public static function get(string $key): ?string
    {
        return $_SESSION[$key];
    }

    /**
     * destroy
     *
     * @return void
     */
    public static function destroy(): void
    {
        session_destroy();
    }
}
