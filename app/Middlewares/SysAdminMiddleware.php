<?php
namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class SysAdminMiddleware
{
    public function handle(Request $request)
    {
        if (!Auth::check() || !Auth::user()->canAccessSystem()) {
            app()->route->redirect('/login');
        }
    }
}