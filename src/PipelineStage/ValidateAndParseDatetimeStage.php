<?php

namespace App\PipelineStage;

use App\Communication\RequestParam;
use Webmozart\Assert\Assert;

final class ValidateAndParseDatetimeStage extends ValidateAndParseValueStage
{
    private function createDatetime(string $value): ?\DateTime
    {
        $date = \DateTime::createFromFormat('Y.m.d H:i:s', $value);

        return $date instanceof \DateTime ? $date : null;
    }

    protected function assertValue($value)
    {
        Assert::isInstanceOf(
            $this->createDatetime($value),
            \DateTime::class,
            sprintf('The key %s must be a datetime object', RequestParam::getNameForConstant($this->key))
        );
    }

    protected function parseValue($value)
    {
        return $this->createDatetime($value);
    }
}
