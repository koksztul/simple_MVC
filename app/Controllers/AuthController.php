<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Http\JsonResponse;
use App\Models\User;
use App\Http\Request;
use App\Session;

class AuthController extends Controller
{
    /**
     * login
     *
     * @return void
     */
    public function login(): void
    {
        $this->render('auth/login');
    }

    /**
     * auth
     *
     * @param  Request $request
     * @return void
     */
    public function auth(Request $request): void
    {
        $username = (string)$request->get('username');
        $password = (string)$request->get('password');

        $users = User::where('username', $username);
        $user = array_shift($users);

        if (!empty($user) && password_verify($password, $user->password)) {
            Session::set('logged_in', true);
            Session::set('username', $username);
            redirect('/news');
            return;
        }

        Session::set('error', 'Wrong Login Data!');
        redirect('/');
    }

    /**
     * logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Session::destroy();
        return new JsonResponse();
    }
}
