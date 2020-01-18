<?php

namespace App\EndPoint;

use App\Communication\CommunicationResponse;
use App\Storage\PositionRepository;
use App\Storage\StorageInterface;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\PipelineInterface;
use League\Pipeline\StageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class EndPoint
{
    protected $dto;
    protected $repository;

    public function configureRepository(StorageInterface $storage)
    {
        $this->repository = new PositionRepository($storage);
        return $this;
    }

    public function execute(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->repository instanceof PositionRepository) {
            throw new \Exception('No repository configured to persist the entity.');
        }

        $pipeline = $this->createPipeLine();
        $result = $pipeline->process($request->getParsedBody());

        try {
            return $this->handle($request, $result);
        } catch (\Exception $e) {
            /** @todo Log error */
            return CommunicationResponse::INVALID_REQUEST($e->getMessage());
        }
    }

    /** @return Pipeline */
    private function createPipeLine(): PipelineInterface
    {
        $pipelineBuilder = new PipelineBuilder();
        foreach ($this->getStages() as $stage) {
            $pipelineBuilder->add($stage);
        }

        return $pipelineBuilder->build();
    }

    /** @return StageInterface[] */
    protected abstract function getStages(): array;

    protected abstract function handle(ServerRequestInterface $request, $command): ResponseInterface;
}
