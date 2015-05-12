<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\CreateChecklist as CreateChecklistCommand;

class CreateChecklistTest extends \PHPUnit_Framework_TestCase
{

    private function getRepositoryMock()
    {
        $repository = $this->getMockBuilder('Fornaza\Domain\Repositories\Checklist')
                           ->getMock();

        return $repository;
    }

    public function test_create_a_checklist_without_steps()
    {
        $this->setExpectedException('DomainException');
        $repository = $this->getRepositoryMock();

        $useCase = new CreateChecklist($repository);

        $command = new CreateChecklistCommand('Test Checklist', []);
        $useCase->execute($command);
    }

    public function test_create_a_checklist_with_one_step()
    {
        $checklistName = 'Test Checklist';

        $repository = $this->getRepositoryMock();
        $repository->expects($this->once())
                   ->method('save')
                   ->with($this->callback(function($checklist) use ($checklistName) {
                        $steps = $checklist->getSteps();

                        return $checklist->getName() == $checklistName &&
                            count($steps) == 1;
                    }));

        $useCase = new CreateChecklist($repository);

        $command = new CreateChecklistCommand($checklistName, ['First Step']);
        $useCase->execute($command);
    }
}
