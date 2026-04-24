<?php
namespace Controller;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class AuthController
{
    public function showLoginForm(): string
    {
        return (new View())->render('site.login');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) {
                app()->route->redirect('/hello');
                return false;
            }
            return (new View())->render('site.login', ['message' => 'Неверный логин или пароль']);
        }

        return $this->showLoginForm();
    }
}