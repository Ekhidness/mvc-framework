<?php
namespace Validators;

use Src\Validator\Validator;

class RoomValidator
{
    public static function make(array $data): Validator
    {
        return new Validator($data, [
            'RoomNumber'   => ['required', 'regex:/^[0-9]+$/'],
            'RoomTypeID'   => ['required'],
            'DepartmentID' => ['required']
        ], [
            'required' => 'Поле :field обязательно',
            'regex'    => 'Поле :field должно содержать только положительные целые числа'
        ]);
    }
}