<?php

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\NewsController;
use App\Session;
use App\Controllers\ErrorController;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Request;

require '../vendor/autoload.php';

if (env('DEBUG_MODE') == 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

Session::init();
$request = new Request();
$router = new Router();

$router->addRoute('GET', '/', AuthController::class, 'login', '')->only('guest');
$router->addRoute('POST', '/login/auth', AuthController::class, 'auth')->only('guest');
$router->addRoute('POST', '/logout', AuthController::class, 'logout')->only('auth');
$router->addRoute('GET', '/news', NewsController::class, 'index')->only('auth');
$router->addRoute('POST', '/news/store', NewsController::class, 'store')->only('auth');
$router->addRoute('GET', '/news/list', NewsController::class, 'list')->only('auth');
$router->addRoute('POST', '/news/delete', NewsController::class, 'delete')->only('auth');
$router->addRoute('POST', '/news/edit', NewsController::class, 'edit')->only('auth');

try {
    $router->dispatch(gePathUrl(), $request);
} catch (Exception $e) {
    (new ErrorController())->error($e, 405);
}
