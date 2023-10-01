<?php

namespace App;

use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\GuestMiddleware;
use App\Http\Request;
use Exception;

class Router
{
    public array $routes = [];

    /**
     * addRoute
     *
     * @param  string $method
     * @param  string $route
     * @param  string $controller
     * @param  string $action
     * @return Router
     */
    public function addRoute(string $method, string $route, string $controller, string $action): Router
    {
        $this->routes[$route] = ['method' => $method, 'controller' => $controller, 'action' => $action];
        return $this;
    }


    /**
     * only
     *
     * @param  string $middleware
     * @return Router
     */
    public function only(string $middleware): Router
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }

    /**
     * dispatch
     *
     * @param  string $uri
     * @param  Request $request
     * @return void
     */
    public function dispatch(string $uri, Request $request): void
    {
        if (array_key_exists($uri, $this->routes)) {
            if ($this->routes[$uri]['method'] !== $request->getMethod()) {
                throw new Exception('Incorrect request method.');
            }
            if ($this->routes[$uri]['middleware'] === 'guest') {
                (new GuestMiddleware())->handle();
            }
            if ($this->routes[$uri]['middleware'] === 'auth') {
                (new AuthMiddleware())->handle();
            }
            $controllerClass = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];

            $controller = new $controllerClass();

            $controller->$action($request);
        }
    }
}
