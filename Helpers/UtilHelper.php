<?php

namespace app\Helpers;
class UtilHelper
{
    public static function randomString($n) {
        $string = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = '';
        for($i = 0; $i < $n; $i++) $str .= $string[rand(0, strlen($string) - 1)];
        return $str;
    }
}