<?php
declare(strict_types = 1);

namespace src;

class MyClass
{
    public function concatenateString(string $str1, string $str2): string
    {
        return $str1 . $str2;
    }
}