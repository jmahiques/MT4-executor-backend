<?php

namespace App\PipelineStage;

use Webmozart\Assert\Assert;

final class MapFloatStage extends MapValueStage
{
    protected function assertValue($value)
    {
        Assert::float(
            filter_var($value, FILTER_VALIDATE_FLOAT),
            sprintf('The key %s must be a float', $this->property)
        );
    }

    protected function parseValue($value)
    {
        return (float)$value;
    }
}
