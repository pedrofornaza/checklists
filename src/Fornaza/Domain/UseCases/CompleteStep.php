<?php

namespace Fornaza\Domain\UseCases;

use DomainException;
use Fornaza\Domain\Commands\CompleteStep as CompleteStepCommand;
use Fornaza\Domain\Repositories\Step as StepRepository;

class CompleteStep
{
    public function __construct(StepRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CompleteStepCommand $command)
    {
        $step = $this->repository->find($command->stepId);
        if ( ! $step) {
            throw new DomainException('Cannot complete a non existent step.');
        }

        $step->complete();

        $this->repository->save($step);
    }
}
