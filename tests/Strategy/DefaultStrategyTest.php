<?php

namespace App\Tests\Strategy;

use App\Command\OpenPositionCommand;
use App\Entity\Position;
use App\Strategy\DefaultStrategy;
use App\ValueObject\Level;
use PHPUnit\Framework\TestCase;

class DefaultStrategyTest extends TestCase
{
    public function testValidCreationLevel()
    {
        $command = new OpenPositionCommand(
            1,
            1,
            1.12,
            new \DateTime('now'),
            'EURUSD',
            5,
            0.02,
            Position::TYPE_BUY,
            20,
            20,
            20,
            20
        );

        $strategy = DefaultStrategy::fromCommand($command);
        self::assertInstanceOf(Level::class, $strategy->computeStopLevel($command));
        self::assertInstanceOf(Level::class, $strategy->computePartialStopLevel($command));
        self::assertInstanceOf(Level::class, $strategy->computeProfitLevel($command));
        self::assertInstanceOf(Level::class, $strategy->computePartialProfitLevel($command));
    }

    public function testUnknownPositionType()
    {
        $command = new OpenPositionCommand(
            1,
            1,
            1.12,
            new \DateTime('now'),
            'EURUSD',
            5,
            0.02,
            'type',
            20,
            20,
            20,
            20
        );

        $strategy = DefaultStrategy::fromCommand($command);

        self::expectExceptionMessage('Position type must be one of: '.implode(',', Position::getPositionTypes()));
        $strategy->computeStopLevel($command);
    }

    /**
     * @dataProvider provideBuyValues
     */
    public function testValidBuyValues($openPrice, $digits, $stop, $partialStop, $profit, $partialProfit, $stopPrice, $partialStopPrice, $profitPrice, $partialProfitPrice)
    {
        $command = new OpenPositionCommand(
            1,
            1,
            $openPrice,
            new \DateTime('now'),
            'EURUSD',
            $digits,
            0.02,
            Position::TYPE_BUY,
            $stop,
            $partialStop,
            $profit,
            $partialProfit
        );

        $strategy = DefaultStrategy::fromCommand($command);
        self::assertEquals($stopPrice, $strategy->computeStopLevel($command)->atPrice());
        self::assertEquals($partialStopPrice, $strategy->computePartialStopLevel($command)->atPrice());
        self::assertEquals($profitPrice, $strategy->computeProfitLevel($command)->atPrice());
        self::assertEquals($partialProfitPrice, $strategy->computePartialProfitLevel($command)->atPrice());
    }

    public function provideBuyValues()
    {
        return [
            [1.1220, 5, 20, 16, 80, 160, 1.12, 1.1204, 1.13, 1.138],
            [1.1220, 5, 10, 8, 20, 40, 1.1210, 1.1212, 1.1240, 1.1260],
            [1.1190, 5, 20, 16, 60, 120, 1.1170, 1.1174, 1.1250, 1.1310],
            [1.1000, 5, 40, 36, 120, 240, 1.0960, 1.0964, 1.1120, 1.1240],
        ];
    }

    /**
     * @dataProvider provideSellValues
     */
    public function testValidSellValues($openPrice, $digits, $stop, $partialStop, $profit, $partialProfit, $stopPrice, $partialStopPrice, $profitPrice, $partialProfitPrice)
    {
        $command = new OpenPositionCommand(
            1,
            1,
            $openPrice,
            new \DateTime('now'),
            'EURUSD',
            $digits,
            0.02,
            Position::TYPE_SELL,
            $stop,
            $partialStop,
            $profit,
            $partialProfit
        );

        $strategy = DefaultStrategy::fromCommand($command);
        self::assertEquals($stopPrice, $strategy->computeStopLevel($command)->atPrice());
        self::assertEquals($partialStopPrice, $strategy->computePartialStopLevel($command)->atPrice());
        self::assertEquals($profitPrice, $strategy->computeProfitLevel($command)->atPrice());
        self::assertEquals($partialProfitPrice, $strategy->computePartialProfitLevel($command)->atPrice());
    }

    public function provideSellValues()
    {
        return [
            [1.1220, 5, 20, 16, 80, 160, 1.1240, 1.1236, 1.1140, 1.1060],
            [1.1220, 5, 10, 8, 20, 40, 1.1230, 1.1228, 1.1200, 1.1180],
            [1.1190, 5, 20, 16, 60, 120, 1.1210, 1.1206, 1.1130, 1.1070],
            [1.1000, 5, 40, 36, 120, 240, 1.1040, 1.1036, 1.0880, 1.0760],
        ];
    }
}
