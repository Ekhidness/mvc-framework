<?php
namespace ekhidness\PhoneUtils;

class PhoneFormatter
{
    public static function format(string $number): string
    {
        $clean = preg_replace('/[^0-9]/', '', $number);

        if (strlen($clean) === 10) {
            return '(' . substr($clean, 0, 3) . ') ' . substr($clean, 3, 3) . '-' . substr($clean, 6, 2) . '-' . substr($clean, 8, 2);
        }

        if (strlen($clean) === 11 && substr($clean, 0, 1) === '8') {
            $clean = '7' . substr($clean, 1);
        }

        if (strlen($clean) === 11 && substr($clean, 0, 1) === '7') {
            return '+7 (' . substr($clean, 1, 3) . ') ' . substr($clean, 4, 3) . '-' . substr($clean, 7, 2) . '-' . substr($clean, 9, 2);
        }

        return $number;
    }

    public static function isValid(string $number): bool
    {
        $clean = preg_replace('/[^0-9]/', '', $number);
        return strlen($clean) >= 10 && strlen($clean) <= 11;
    }
}