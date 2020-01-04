<?php

use App\Entity\Position;
use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testValidBuyPosition()
    {
        $buyPosition = Position::BUY(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1260), Direction::GREATER())
        );
        self::assertInstanceOf(Position::class, $buyPosition);
    }

    public function testValidSellPosition()
    {
        $sellPosition = Position::SELL(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1250), Direction::GREATER()),
            new Level(new Price(1.1245), Direction::GREATER()),
            new Level(new Price(1.1210), Direction::LESS()),
            new Level(new Price(1.1220), Direction::LESS())
        );
        self::assertInstanceOf(Position::class, $sellPosition);
    }

    public function testInvalidDateThrowsException()
    {
        self::expectExceptionMessage('The open time cannot me higher than now');
        $this->buyPositionFactory('openTime', new \DateTime('now +2days'));
    }

    public function testInvalidOpenPrice()
    {
        self::expectExceptionMessage('The open price should be greater than 0');
        $this->buyPositionFactory('openPrice', 0);
    }

    public function testInvalidLots()
    {
        self::expectExceptionMessage('Lots should be greater than 0');
        $this->buyPositionFactory('lots', 0);
    }

    public function testInvalidDigits()
    {
        self::expectExceptionMessage('Digits should be greater than 0');
        $this->buyPositionFactory('digits', 0);
    }

    public function testInvalidTicket()
    {
        self::expectExceptionMessage('Ticket should be greater than 0');
        $this->buyPositionFactory('ticket', 0);
    }

    private function buyPositionFactory($property, $value)
    {
        return Position::BUY(
            123,
            $property === 'ticket' ? $value : 123,
            $property === 'openTime' ? $value : new \DateTime('now'),
            $property === 'openPrice' ? $value : 1.1221,
            $property === 'lots' ? $value : 0.02,
            $property === 'digits' ? $value : 4,
            'EURUSD',
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1260), Direction::GREATER())
        );
    }

    //BUY LEVEL BUSINESS RULES
    public function testBuyStopMustBeLessThanPartialStop()
    {
        self::expectExceptionMessage('The stop must be less than the partial stop');
        Position::BUY(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1260), Direction::GREATER())
        );
    }

    public function testBuyPartialStopMustBeLessThanOpenPrice()
    {
        self::expectExceptionMessage('The partial stop must be less than the open price');
        Position::BUY(
            1,
            123,
            new \DateTime('now'),
            1.1231,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1260), Direction::GREATER())
        );
    }

    public function testBuyOpenPriceMustBeLessThanPartialProfit()
    {
        self::expectExceptionMessage('The open price must be less than the partial profit');
        Position::BUY(
            1,
            123,
            new \DateTime('now'),
            1.1265,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1260), Direction::GREATER())
        );
    }

    public function testBuyPartialProfitMustBeLessThanProfit()
    {
        self::expectExceptionMessage('The partial profit must be less than the profit');
        Position::BUY(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1235), Direction::LESS()),
            new Level(new Price(1.1270), Direction::GREATER()),
            new Level(new Price(1.1280), Direction::GREATER())
        );
    }

    //SELL LEVEL BUSINESS RULES
    public function testSellStopMustBeGreaterThanPartialStop()
    {
        self::expectExceptionMessage('The stop must be greater than the partial stop');
        Position::SELL(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1270), Direction::GREATER()),
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1220), Direction::LESS()),
            new Level(new Price(1.1230), Direction::LESS())
        );
    }

    public function testSellPartialStopMustBeGreaterThanOpenPrice()
    {
        self::expectExceptionMessage('The partial stop must be greater than the open price');
        Position::SELL(
            1,
            123,
            new \DateTime('now'),
            1.1275,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1270), Direction::GREATER()),
            new Level(new Price(1.1220), Direction::LESS()),
            new Level(new Price(1.1230), Direction::LESS())
        );
    }

    public function testSellOpenPriceMustBeGreaterThanPartialStop()
    {
        self::expectExceptionMessage('The open price must be greater than the partial profit');
        Position::SELL(
            1,
            123,
            new \DateTime('now'),
            1.1225,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1270), Direction::GREATER()),
            new Level(new Price(1.1220), Direction::LESS()),
            new Level(new Price(1.1230), Direction::LESS())
        );
    }

    public function testSellPartialProfitMustBeGreaterThanProfit()
    {
        self::expectExceptionMessage('The partial profit must be greater than the profit');
        Position::SELL(
            1,
            123,
            new \DateTime('now'),
            1.1240,
            0.02,
            4,
            'EURUSD',
            new Level(new Price(1.1280), Direction::GREATER()),
            new Level(new Price(1.1270), Direction::GREATER()),
            new Level(new Price(1.1230), Direction::LESS()),
            new Level(new Price(1.1220), Direction::LESS())
        );
    }
}
