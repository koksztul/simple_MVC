<?php

namespace App\Http\Middlewares;

use App\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!Session::keyExists('logged_in')) {
            redirect('/');
            exit();
        }
    }
}
