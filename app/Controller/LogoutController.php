<?php
namespace Controller;

use Src\Auth\Auth;

class LogoutController
{
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }
}