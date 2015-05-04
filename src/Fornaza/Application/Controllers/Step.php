<?php

namespace Fornaza\Application\Controllers;

use Fornaza\Domain\Commands\CompleteStep as CompleteStepCommand;
use Fornaza\Domain\Repositories\Step as StepRepository;
use Fornaza\Domain\UseCases\CompleteStep as CompleteStepUseCase;
use Symfony\Component\HttpFoundation\Response;

class Step
{
    private $container;
    private $repository;
    private $twig;

    public function __construct($container, StepRepository $repository)
    {
        $this->container = $container;
        $this->repository = $repository;
    }

    public function completeAction($id)
    {
        try {
            $command = new CompleteStepCommand($id);

            $useCase = new CompleteStepUseCase($this->repository);
            $useCase->execute($command);

        } catch (Exception $e) {
            $this->container['session']->getFlashBag()->add('error', $e->getMessage());
        }

        return new Response();
    }
}
