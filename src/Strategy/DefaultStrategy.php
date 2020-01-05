<?php

namespace App\Strategy;

use App\Command\OpenPositionCommand;
use App\Entity\Position;
use App\Utils\PriceNormalizer;
use App\ValueObject\Direction;
use App\ValueObject\Level;
use App\ValueObject\Price;
use Webmozart\Assert\Assert;

final class DefaultStrategy implements StrategyInterface
{
    private $stop;
    private $partialStop;
    private $partialProfit;
    private $profit;
    private $lots;
    private $digitsOffset;

    public function __construct(
        int $stop,
        int $partialStop,
        int $profit,
        int $partialProfit,
        float $lots,
        int $digitsOffset = 1
    ) {
        $this->stop = $stop;
        $this->partialStop = $partialStop;
        $this->profit = $profit;
        $this->partialProfit = $partialProfit;
        $this->lots = $lots;
        $this->digitsOffset = $digitsOffset;
    }

    public static function fromCommand(OpenPositionCommand $command): self
    {
        return new self(
            $command->getStop(),
            $command->getPartialStop(),
            $command->getProfit(),
            $command->getPartialProfit(),
            $command->getLots()
        );
    }

    public function computeStopLevel(OpenPositionCommand $command): Level
    {
        Position::assertPositionType($command->getType());

        $normalizedPips = PriceNormalizer::getPriceWithPips(
            $command->getDigits(),
            $command->getStop(),
            $command->getOpenPrice()
        );

        return $command->getType() === Position::TYPE_BUY
            ? new Level(new Price($command->getOpenPrice() - $normalizedPips), Direction::LESS())
            : new Level(new Price($command->getOpenPrice() + $normalizedPips), Direction::GREATER());
    }

    public function computePartialStopLevel(OpenPositionCommand $command): Level
    {
        Position::assertPositionType($command->getType());

        $normalizedPips = PriceNormalizer::getPriceWithPips(
            $command->getDigits(),
            $command->getPartialStop(),
            $command->getOpenPrice()
        );

        return $command->getType() === Position::TYPE_BUY
            ? new Level(new Price($command->getOpenPrice() - $normalizedPips), Direction::LESS())
            : new Level(new Price($command->getOpenPrice() + $normalizedPips), Direction::GREATER());
    }

    public function computeProfitLevel(OpenPositionCommand $command): Level
    {
        Position::assertPositionType($command->getType());

        $normalizedPips = PriceNormalizer::getPriceWithPips(
            $command->getDigits(),
            $command->getProfit(),
            $command->getOpenPrice()
        );

        return $command->getType() === Position::TYPE_BUY
            ? new Level(new Price($command->getOpenPrice() + $normalizedPips), Direction::GREATER())
            : new Level(new Price($command->getOpenPrice() - $normalizedPips), Direction::LESS());
    }

    public function computePartialProfitLevel(OpenPositionCommand $command): Level
    {
        Position::assertPositionType($command->getType());

        $normalizedPips = PriceNormalizer::getPriceWithPips(
            $command->getDigits(),
            $command->getPartialProfit(),
            $command->getOpenPrice()
        );

        return $command->getType() === Position::TYPE_BUY
            ? new Level(new Price($command->getOpenPrice() + $normalizedPips), Direction::GREATER())
            : new Level(new Price($command->getOpenPrice() - $normalizedPips), Direction::LESS());
    }
}
