<?php

namespace App\Http\Middlewares;

use App\Session;

class GuestMiddleware
{
    public function handle()
    {
        if (Session::keyExists('logged_in')) {
            redirect('/news');
            exit();
        }
    }
}
