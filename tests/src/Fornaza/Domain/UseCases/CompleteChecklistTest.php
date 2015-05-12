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

    public function test_complete_valid_checklist()
    {
        $checklist = $this->getMockBuilder('Fornaza\Domain\Entities\Checklist')
                          ->disableOriginalConstructor()
                          ->getMock();

        $checklist->expects($this->once())
                  ->method('complete');

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
