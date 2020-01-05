<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use Webmozart\Assert\Assert;

final class ValidateAndParseFloatStage extends ValidateAndParseValueStage
{
    protected function assertValue($value)
    {
        Assert::float(
            filter_var($value, FILTER_VALIDATE_FLOAT),
            sprintf('The key %s must be a float', RequestParam::getNameForConstant($this->key))
        );
    }

    protected function parseValue($value)
    {
        return (float)$value;
    }
}
