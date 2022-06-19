<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function cleanPhone($phone): string
    {
        $phone = trim($phone);
        $phone = str_replace(['+', '-', ' ', '(', ')', '/', '\\'], '', $phone);
        return substr_replace($phone, '7', 0, 1);
    }
}
