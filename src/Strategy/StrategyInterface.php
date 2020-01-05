<?php

namespace App\Strategy;

use App\Command\OpenPositionCommand;
use App\ValueObject\Level;

interface StrategyInterface
{
    public function computeStopLevel(OpenPositionCommand $command): Level;
    public function computePartialStopLevel(OpenPositionCommand $command): Level;
    public function computeProfitLevel(OpenPositionCommand $command): Level;
    public function computePartialProfitLevel(OpenPositionCommand $command): Level;
}
