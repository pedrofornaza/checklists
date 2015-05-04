<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\CreateChecklist as CreateChecklistCommand;
use Fornaza\Domain\Entities\Checklist;
use Fornaza\Domain\Entities\Step;
use Fornaza\Domain\Repositories\Checklist as ChecklistRepository;

class CreateChecklist
{
    public function __construct(ChecklistRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateChecklistCommand $command)
    {
        $checklist = new Checklist($command->checklistName);

        foreach ($command->stepsDescription as $stepDescription) {
            $checklist->addStep($stepDescription);
        }

        $this->repository->save($checklist);
    }
}
