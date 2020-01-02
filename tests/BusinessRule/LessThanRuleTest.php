<?php

use App\BusinessRule\LessThanRule;
use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

class LessThanRuleTest extends TestCase
{
    public function testValid()
    {
        $rule = new LessThanRule(
            new Level(new Price(1.12), Direction::GREATER()),
            new Level(new Price(1.13), Direction::GREATER()),
            new \Exception()
        );

        $rule->validate();
        self::assertInstanceOf(LessThanRule::class, $rule);
    }

    public function testError()
    {
        $rule = new LessThanRule(
            new Level(new Price(1.13), Direction::GREATER()),
            new Level(new Price(1.12), Direction::GREATER()),
            new \Exception()
        );
        self::expectException(\Exception::class);
        $rule->validate();
    }
}
