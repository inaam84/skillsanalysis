<?php
declare(strict_types = 1);

namespace src;

class NINOValidator
{
    private static $restrictedPrefixes = [
        "BG", "GB", "KN", "NK", "NT", "TN", "ZZ"
    ];

    private static $validFirstChar = "ABCEGHJKLMNOPRSTWXYZ";
    private static $validSecondChar = "ABCEGHJKLMNPRSTWXYZ";
    private static $validLastChar = "ABCD";

    public static function generate(): string
    {
        $f = self::firstCharacter();
        do {
            $s = self::secondCharacter();
        } while (in_array("{$f}{$s}", self::$restrictedPrefixes) || $s === "O");
        
        return $f . $s . str_pad((string) mt_rand(0, 999999), 6, '0', STR_PAD_LEFT) . self::lastCharacter();
    }

    private static function firstCharacter()
    {
        return static::$validFirstChar[mt_rand(0, strlen(static::$validFirstChar)-1)];
    }

    private static function secondCharacter()
    {
        return static::$validSecondChar[mt_rand(0, strlen(static::$validSecondChar)-1)];
    }

    private static function lastCharacter()
    {
        return static::$validLastChar[mt_rand(0, strlen(static::$validLastChar)-1)];
    }

    public static function validate(string $nino): bool
    {
        $nino = strtoupper(str_replace(' ', '', $nino));

        //The letter O is not used as the second letter of a prefix
        if($nino[1] === "O")
        {
            return false;
        }
        
        if(!preg_match('/^[A-Z]{2}[0-9]{6}[A-D]{1}$/', $nino))
        {
            return false;
        }

        //Prefixes BG, GB, KN, NK, NT, TN and ZZ are not to be used
        $firstTwoCharacters = substr($nino, 0, 2);
        if(in_array($firstTwoCharacters, ["BG", "GB", "KN", "NK", "NT", "TN", "ZZ"]))
        {
            return false;
        }

        //The characters D, F, I, Q, U, and V are not used as either the first or second letter of a NINO prefix.
        if(in_array($nino[0], ["D", "F", "I", "Q", "U"]) || in_array($nino[0], ["D", "F", "I", "Q", "U"]))
        {
            return false;
        }

        return true;
    }
}

