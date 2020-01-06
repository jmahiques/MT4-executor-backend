<?php

use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

final class LevelTest extends TestCase
{
    public function testGreaterLevel()
    {
        $level = new Level(new Price(1.1221), Direction::GREATER());

        self::assertFalse($level->reached(1.10));
        self::assertFalse($level->hasReachedPrice());
        self::assertEquals($level->atPrice(), 1.1221);
        self::assertNull($level->when());

        self::assertFalse($level->reached(1.1220));
        self::assertFalse($level->hasReachedPrice());
        self::assertEquals($level->atPrice(), 1.1221);
        self::assertNull($level->when());

        self::assertTrue($level->reached(1.1222));
        self::assertTrue($level->hasReachedPrice());
        self::assertInstanceOf(\DateTime::class, $level->when());

        self::expectExceptionMessage('The price was reached the level previously');
        $level->reached(1.10);
    }

    public function testLessLevel()
    {
        $level = new Level(new Price(1.1320), Direction::LESS());

        self::assertFalse($level->reached(1.14));
        self::assertFalse($level->hasReachedPrice());
        self::assertEquals($level->atPrice(), 1.1320);
        self::assertNull($level->when());

        self::assertFalse($level->reached(1.1322));
        self::assertFalse($level->hasReachedPrice());
        self::assertEquals($level->atPrice(), 1.1320);
        self::assertNull($level->when());

        self::assertTrue($level->reached(1.1318));
        self::assertTrue($level->hasReachedPrice());
        self::assertInstanceOf(\DateTime::class, $level->when());

        self::expectExceptionMessage('The price was reached the level previously');
        $level->reached(1.10);
    }
}
