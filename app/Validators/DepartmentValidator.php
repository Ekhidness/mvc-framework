<?php
namespace Validators;

use Src\Validator\Validator;

class DepartmentValidator
{
    public static function make(array $data): Validator
    {
        return new Validator($data, [
            'DepartmentName'   => ['required', 'regex:/^[a-zA-Zа-яА-ЯёЁ](?:[a-zA-Zа-яА-ЯёЁ -]*[a-zA-Zа-яА-ЯёЁ])?$/u'],
            'DepartmentTypeID' => ['required']
        ], [
            'required' => 'Поле :field обязательно',
            'regex'    => 'Поле :field должно содержать только русские/английские буквы и тире. Тире не может быть первым или последним символом.'
        ]);
    }
}