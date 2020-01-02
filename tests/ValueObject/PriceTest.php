<?php

use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    public function testValid()
    {
        self::assertInstanceOf(Price::class, new Price(0.12));
    }

    public function testError()
    {
        self::expectException(\Exception::class);
        new Price(0);
    }
}
