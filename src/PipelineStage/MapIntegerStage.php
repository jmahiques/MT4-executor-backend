<?php

namespace App\PipelineStage;

use Webmozart\Assert\Assert;

final class MapIntegerStage extends MapValueStage
{
    protected function assertValue($value)
    {
        Assert::integerish($value, sprintf('The key %s must be a integer', $this->property));
    }

    protected function parseValue($value)
    {
        return (int)$value;
    }
}
