<?php

namespace App\Tests\Strategy;

use App\Entity\Position;
use App\Strategy\DefaultStrategy;
use PHPUnit\Framework\TestCase;

class DefaultStrategyTest extends TestCase
{
    public function testUnknownPositionType()
    {
        $position = new Position();
        $position->type = 'unknown';
        $strategy = new DefaultStrategy(20, 16, 60, 120, 0.02);

        self::expectException(\Exception::class);
        $strategy->apply($position);
    }

    public function testBuy()
    {
        $strategy = new DefaultStrategy(20, 16, 60, 120, 0.02);
        $position = $strategy->apply(
            Position::BUY(new \DateTime('now'), 1.1220, null, null, 5, 'EURUSD', 22331133)
        );

        self::assertEquals(1.1200, $position->stop);
        self::assertEquals(1.1204, $position->partialStop);
        self::assertEquals(1.1340, $position->profit);
        self::assertEquals(1.1280, $position->partialProfit);
    }

    public function testSell()
    {
        $strategy = new DefaultStrategy(20, 16, 60, 120, 0.02);
        $position = $strategy->apply(
            Position::SELL(new \DateTime('now'), 1.1280, null, null, 5, 'EURUSD', 22331133)
        );

        self::assertEquals(1.1300, $position->stop);
        self::assertEquals(1.1296, $position->partialStop);
        self::assertEquals(1.1160, $position->profit);
        self::assertEquals(1.1220, $position->partialProfit);
    }
}
