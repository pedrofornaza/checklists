<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\CompleteChecklist as CompleteChecklistCommand;
use Fornaza\Domain\Entities\Checklist;
use Fornaza\Domain\Entities\Step;

class CompleteChecklistTest extends \PHPUnit_Framework_TestCase
{
    private function getRepositoryMock($return)
    {
        $repository = $this->getMockBuilder('Fornaza\Domain\Repositories\Checklist')
                           ->getMock();

        $repository->expects($this->once())
                   ->method('find')
                   ->with($this->equalTo(1))
                   ->will($this->returnValue($return));

        return $repository;
    }

    public function test_complete_checklist_without_steps()
    {
        $checklist = new Checklist('Test Checklist');
        $repository = $this->getRepositoryMock($checklist);

        $useCase = new CompleteChecklist($repository);

        $command = new CompleteChecklistCommand(1);
        $useCase->execute($command);
    }

    public function test_complete_checklist_with_completed_step()
    {
        $checklist = new Checklist('Test Checklist');
        $step = $checklist->addStep('Test Step');
        $step->complete();

        $repository = $this->getRepositoryMock($checklist);

        $useCase = new CompleteChecklist($repository);

        $command = new CompleteChecklistCommand(1);
        $useCase->execute($command);
    }

    public function test_complete_checklist_with_not_completed_step()
    {
        $this->setExpectedException('DomainException');

        $checklist = new Checklist('Test Checklist');
        $step = $checklist->addStep('Test Step');

        $repository = $this->getRepositoryMock($checklist);

        $useCase = new CompleteChecklist($repository);

        $command = new CompleteChecklistCommand(1);
        $useCase->execute($command);
    }

    public function test_complete_non_existent_checklist()
    {
        $this->setExpectedException('DomainException');

        $repository = $this->getRepositoryMock(null);

        $useCase = new CompleteChecklist($repository);

        $command = new CompleteChecklistCommand(1);
        $useCase->execute($command);
    }
}
