<?php

use App\EnvLoader;
use App\Session;

function getCurrentUrl(): string
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function getHostUrl(): string
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
}

function gePathUrl(): string
{
    return $_SERVER['REQUEST_URI'];
}

function redirect(string $url): void
{
    header('Location: ' . $url);
}

function env(string $conf): string
{
    $env = new EnvLoader(__DIR__ . '/../.env');
    return $env->get($conf);
}

function authGetUsername(): ?string
{
    return Session::keyExists('username') ? Session::get('username') : null;
}
