<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\CreateChecklist as CreateChecklistCommand;

class CreateChecklistTest extends \PHPUnit_Framework_TestCase
{

    private function getRepositoryMock($callback)
    {
        $repository = $this->getMockBuilder('Fornaza\Domain\Repositories\Checklist')
                           ->getMock();

        $checklistName = 'Test Checklist';

        $repository->expects($this->once())
                   ->method('save')
                   ->with($this->callback($callback));

        return $repository;
    }

    public function test_create_a_checklist_without_steps()
    {
        $checklistName = 'Test Checklist';
        $repository = $this->getRepositoryMock(function($checklist) use ($checklistName) {
            $steps = $checklist->getSteps();

            return $checklist->getName() == $checklistName &&
                   empty($steps);
        });

        $useCase = new CreateChecklist($repository);

        $command = new CreateChecklistCommand($checklistName, array());
        $useCase->execute($command);
    }

    public function test_create_a_checklist_with_one_step()
    {
        $checklistName = 'Test Checklist';
        $repository = $this->getRepositoryMock(function($checklist) use ($checklistName) {
            $steps = $checklist->getSteps();

            return $checklist->getName() == $checklistName &&
                   count($steps) == 1;
        });

        $useCase = new CreateChecklist($repository);

        $command = new CreateChecklistCommand($checklistName, array('First Step'));
        $useCase->execute($command);
    }
}
