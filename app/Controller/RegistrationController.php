<?php
namespace Controller;

use Model\User;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class RegistrationController
{
    public function showForm(): string
    {
        return (new View())->render('site.signup');
    }

    public function register(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'Login' => ['required', 'unique:Users,Login'],
                'PasswordHash' => ['required']
            ], [
                'required' => 'Поле :field обязательно',
                'unique' => 'Логин занят'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.signup', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            User::create($request->all());
            app()->route->redirect('/login');
            return false;
        }

        return $this->showForm();
    }
}