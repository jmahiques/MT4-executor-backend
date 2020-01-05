<?php

namespace App\Utils;

class PriceNormalizer
{
    public static function getPriceWithPips(int $digits, int $pips, int $digitsOffset = 1)
    {
        $normalizedPips = $pips/pow(10, $digits-$digitsOffset);
        return (float)number_format($normalizedPips, $pips);
    }
}
