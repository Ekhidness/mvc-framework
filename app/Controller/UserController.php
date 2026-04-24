<?php
namespace Controller;

use Model\Role;
use Model\User;
use Src\Request;
use Src\View;
use Validators\UserValidator;

class UserController
{
    public function index(): string
    {
        $users = User::with('role')->whereHas('role', function ($q) {
            $q->where('RoleName', 'sysadmin');
        })->get();
        return (new View())->render('user.index', ['users' => $users]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            $sysadminRole = Role::where('RoleName', 'sysadmin')->first();

            $preparedData = [
                'Login'        => $data['login'] ?? '',
                'PasswordHash' => $data['password'] ?? '',
                'RoleID'       => $sysadminRole ? $sysadminRole->RoleID : 2,
                'IsBlocked'    => 0
            ];

            $validator = UserValidator::make($preparedData);
            if ($validator->fails()) {
                return (new View())->render('user.create', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            User::create($preparedData);
            app()->route->redirect('/admin/users');
            return false;
        }

        return (new View())->render('user.create');
    }
}