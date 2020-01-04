<?php

namespace App\PipelineStage;

use App\DTO\PipelineInfo;
use League\Pipeline\StageInterface;
use Webmozart\Assert\Assert;

class DtoValueMapper implements StageInterface
{
    private $key;
    private $property;
    private $exceptionMessage;

    public function __construct($key, $property, $exceptionMessage)
    {
        $this->key = $key;
        $this->property = $property;
        $this->exceptionMessage = $exceptionMessage;
    }

    /**
     * @param PipelineInfo $payload
     * @return PipelineInfo
     */
    public function __invoke($payload)
    {
        Assert::keyExists($payload->payload, $this->key, $this->exceptionMessage);
        $payload->dto->{$this->property} = $payload->payload[$this->key];

        return $payload;
    }
}
