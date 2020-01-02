<?php

use App\BusinessRule\GreaterThanRule;
use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

class GreaterThanRuleTest extends TestCase
{
    public function testValid()
    {
        $rule = new GreaterThanRule(
            new Level(new Price(1.13), Direction::GREATER()),
            new Level(new Price(1.12), Direction::GREATER()),
            new \Exception()
        );

        $rule->validate();
        self::assertInstanceOf(GreaterThanRule::class, $rule);
    }

    public function testError()
    {
        $rule = new GreaterThanRule(
            new Level(new Price(1.12), Direction::GREATER()),
            new Level(new Price(1.13), Direction::GREATER()),
            new \Exception()
        );
        self::expectException(\Exception::class);
        $rule->validate();
    }
}
