<?php
include('vendor/autoload.php');

use src\ULNGenerator;

$uln = ULNGenerator::generate();
echo $uln . "\n";
echo isValid($uln) ? "Valid ULN\n" : "Invalid ULN\n";

function isValid(string $uln): bool
{
    if( strlen($uln) < 10 || !ctype_digit($uln) )
    {
        return false;
    }

    $base = substr($uln, 0, 9);
    $checkDigit = (int) substr($uln, 9, 1);
    $expectedCheckDigit = ULNGenerator::calculateCheckDigit($base);

    return (int) $expectedCheckDigit === $checkDigit;
}