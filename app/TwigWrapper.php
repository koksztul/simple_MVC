<?php

namespace App;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

class TwigWrapper
{
    public Environment $twig;

    public function __invoke(): Environment
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);

        $this->twig->addFunction(new TwigFunction('asset', [$this, 'asset']));
        $this->twig->addFunction(new TwigFunction('error', [$this, 'error']));
        $this->twig->addFunction(new TwigFunction('route', [$this, 'route']));
        $this->twig->addFunction(new TwigFunction('flush', [$this, 'flush']));
        $this->twig->addFunction(new TwigFunction('sessionKeyExists', [$this, 'sessionKeyExists']));

        return $this->twig;
    }

    /**
     * asset
     *
     * @param  string $src
     * @return string
     */
    public function asset(string $src): string
    {
        return getHostUrl() . '/public/' . $src;
    }

    /**
     * route
     *
     * @param  string $route
     * @return string
     */
    public function route(string $route): string
    {
        return env('APP_URL') . $route;
    }

    /**
     * sessionKeyExists
     *
     * @param  string $key
     * @return bool
     */
    public static function sessionKeyExists(string $key): bool
    {
        return Session::keyExists($key);
    }

    /**
     * flush
     *
     * @param  string $key
     * @return ?string
     */
    public static function flush(string $key): ?string
    {
        $val = Session::get($key);
        Session::unset($key);
        return $val;
    }
}
