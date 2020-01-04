<?php

use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

final class LevelTest extends TestCase
{
    public function test()
    {
        $level = new Level(new Price(1.1221), Direction::GREATER());

        self::assertFalse($level->reached(1.10));
        self::assertFalse($level->hasReachedPrice());
        self::assertEquals($level->atPrice(), 1.1221);
        self::assertNull($level->when());

        self::assertTrue($level->reached(1.13));
        self::assertTrue($level->hasReachedPrice());
        self::assertInstanceOf(\DateTime::class, $level->when());

        self::expectExceptionMessage('The price was reached the level previously');
        $level->reached(1.10);
    }
}
