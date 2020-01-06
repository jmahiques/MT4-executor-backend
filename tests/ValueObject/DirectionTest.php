<?php

use App\ValueObject\Direction;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    public function testValid()
    {
        self::assertInstanceOf(Direction::class, new Direction(Direction::LESS));
        self::assertInstanceOf(Direction::class, new Direction(Direction::GREATER));
        self::assertInstanceOf(Direction::class, Direction::LESS());
        self::assertInstanceOf(Direction::class, Direction::GREATER());
    }

    public function testThrowException()
    {
        self::expectExceptionMessage('The direction must be in [greater,less]');
        new Direction('direction');
    }
}
