<?php

namespace App\Http;

final class Request
{
    private string $method;
    private array $payload;

    public function __construct()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->payload = match ($this->method) {
                'GET' => $this->payload = $_GET,
                'POST' => $this->payload = $_POST,
                default => throw new \Exception('HTTP method not supported')
            };
        } else {
            throw new \Exception('HTTP method not supported');
        }
    }

    /**
     * isAjax
     *
     * @return bool
     */
    public function isAjax(): bool
    {
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest'
        ) {
            return true;
        }
        return false;
    }

    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * get
     *
     * @param  mixed $key
     * @return string
     */
    public function get(mixed $key): string
    {
        return $this->payload[$key] ?? '';
    }
}
