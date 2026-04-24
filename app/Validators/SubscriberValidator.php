<?php
namespace Validators;

use Src\Validator\Validator;

class SubscriberValidator
{
    public static function make(array $data): Validator
    {
        return new Validator($data, [
            'Surname'      => ['required', 'regex:/^[а-яА-ЯёЁ]+$/u'],
            'Name'         => ['required', 'regex:/^[а-яА-ЯёЁ]+$/u'],
            'Patronymic'   => ['regex:/^[а-яА-ЯёЁ]+$/u'],
            'BirthdayDate' => ['required']
        ], [
            'required' => 'Поле :field обязательно',
            'regex'    => 'Поле :field должно содержать только русские буквы без пробелов и цифр'
        ]);
    }
}