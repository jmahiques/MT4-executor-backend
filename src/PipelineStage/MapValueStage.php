<?php

namespace App\PipelineStage;

use App\DTO\PipelineInfo;
use League\Pipeline\StageInterface;
use Webmozart\Assert\Assert;

abstract class MapValueStage implements StageInterface
{
    protected $key;
    protected $property;

    public function __construct($key, $property)
    {
        $this->key = $key;
        $this->property = $property;
    }

    /**
     * @param PipelineInfo $payload
     * @return PipelineInfo
     */
    public function __invoke($payload)
    {
        Assert::keyExists($payload->payload, $this->key, sprintf('The value for key %s must be sent', $this->property));

        $this->assertValue($payload->payload[$this->key]);

        $payload->dto->{$this->property} = $this->parseValue($payload->payload[$this->key]);

        return $payload;
    }

    protected abstract function assertValue($value);

    protected abstract function parseValue($value);
}
