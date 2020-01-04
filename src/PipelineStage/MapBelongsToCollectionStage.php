<?php

namespace App\PipelineStage;

use Webmozart\Assert\Assert;

final class MapBelongsToCollectionStage extends MapValueStage
{
    private $validValues;

    public function __construct($key, $property, array $validValues)
    {
        parent::__construct($key, $property);
        $this->validValues = $validValues;
    }

    protected function assertValue($value)
    {
        Assert::true(
            in_array($value, $this->validValues),
            sprintf('The %s must be in [%s]', $this->property, implode(',', $this->validValues))
        );
    }

    protected function parseValue($value)
    {
        return $value;
    }
}
