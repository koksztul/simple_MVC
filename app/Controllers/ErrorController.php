<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Http\JsonResponse;
use App\Http\Request;
use Throwable;

class ErrorController extends Controller
{
    /**
     * error
     *
     * @param  Throwable $e
     * @param  int $code
     * @return JsonResponse
     */
    public function error(Throwable $e, int $code = 400): JsonResponse
    {
        return new JsonResponse(['message' => $e->getMessage()], $code);
    }
}
