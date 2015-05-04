<?php

namespace Fornaza\Domain\UseCases;

use DomainException;
use Fornaza\Domain\Commands\CompleteChecklist as CompleteChecklistCommand;
use Fornaza\Domain\Repositories\Checklist as ChecklistRepository;

class CompleteChecklist
{
    public function __construct(ChecklistRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CompleteChecklistCommand $command)
    {
        $checklist = $this->repository->find($command->checklistId);
        if ( ! $checklist) {
            throw new DomainException('Cannot complete a non existent checklist.');
        }

        $checklist->complete();

        $this->repository->save($checklist);
    }
}
