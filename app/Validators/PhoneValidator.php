<?php
namespace Validators;

use Src\Validator\Validator;

class PhoneValidator
{
    public static function make(array $data): Validator
    {
        return new Validator($data, [
            'Number' => ['required', 'unique:Phones,Number'],
            'RoomID' => ['required']
        ], [
            'required' => 'Поле :field обязательно',
            'unique' => 'Номер :value уже существует'
        ]);
    }
}