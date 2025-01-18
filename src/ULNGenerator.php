<?php
declare(strict_types = 1);

namespace src;

class ULNGenerator
{
    public static function generate()
    {
        $base = random_int(1, 9);

        do {
            for($i = 1; $i < 9; $i++)
            {
                $base .= random_int(0, 9);
            }

            $checksumDigit = self::calculateCheckDigit($base);
        } while ($checksumDigit === 10);

        return $base . $checksumDigit;
    }

    public static function calculateCheckDigit(string $base): int
    {
        $weights = range(10, 2);
        $sum = 0;

        for($i = 0; $i < 9; $i++)
        {
            $sum += (int)$base[$i] * $weights[$i];
        }

        $remainder = $sum % 11;
        return 10 - $remainder;
    }
}