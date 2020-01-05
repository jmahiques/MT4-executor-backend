<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use Webmozart\Assert\Assert;

final class ValidateAndParseStringStage extends ValidateAndParseValueStage
{
    protected function assertValue($value)
    {
        Assert::string($value, sprintf('The key %s must be a string', RequestParam::getNameForConstant($this->key)));
    }

    protected function parseValue($value)
    {
        return (string)$value;
    }
}
