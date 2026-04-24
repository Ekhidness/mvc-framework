<?php
namespace Validators;

use Src\Validator\Validator;

class UserValidator
{
    public static function make(array $data): Validator
    {
        return new Validator($data, [
            'Login' => ['required', 'unique:Users,Login'],
            'PasswordHash' => ['required'],
            'RoleID' => ['required']
        ], [
            'required' => 'Поле :field обязательно',
            'unique' => 'Логин :value уже занят'
        ]);
    }
}