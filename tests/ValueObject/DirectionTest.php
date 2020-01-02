<?php

use App\ValueObject\Direction;
use PHPUnit\Framework\TestCase;

final class DirectionTest extends TestCase
{
    public function testValid()
    {
        self::assertInstanceOf(Direction::class, Direction::GREATER());
    }
}
