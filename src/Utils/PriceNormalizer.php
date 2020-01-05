<?php

namespace App\Utils;

class PriceNormalizer
{
    public static function getPriceWithPips(int $digits, int $pips, int $digitsOffset = 1): float
    {
        return $pips/pow(10, $digits-$digitsOffset);
    }
}
