<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\ArchiveChecklist as ArchiveChecklistCommand;
use Fornaza\Domain\Repositories\Checklist as ChecklistRepository;
use DomainException;

class ArchiveChecklist
{
    public function __construct(ChecklistRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ArchiveChecklistCommand $command)
    {
        $checklist = $this->repository->find($command->checklistId);
        if ( ! $checklist) {
            throw new DomainException('Cannot complete a non existent checklist.');
        }

        $checklist->archive();

        $this->repository->save($checklist);
    }
}
