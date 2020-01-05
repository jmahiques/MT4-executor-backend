<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use Webmozart\Assert\Assert;

final class ValidateAndParseIntegerStage extends ValidateAndParseValueStage
{
    protected function assertValue($value)
    {
        Assert::integerish($value, sprintf('The key %s must be a integer', RequestParam::getNameForConstant($this->key)));
    }

    protected function parseValue($value)
    {
        return (int)$value;
    }
}
