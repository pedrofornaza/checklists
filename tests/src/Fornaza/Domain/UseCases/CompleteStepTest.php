<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\CompleteStep as CompleteStepCommand;
use Fornaza\Domain\Entities\Step;

class CompleteStepTest extends \PHPUnit_Framework_TestCase
{
    private function getRepositoryMock($return)
    {
        $repository = $this->getMockBuilder('Fornaza\Domain\Repositories\Step')
                           ->getMock();

        $repository->expects($this->once())
                   ->method('find')
                   ->with($this->equalTo(1))
                   ->will($this->returnValue($return));

        return $repository;
    }

    public function test_complete_step()
    {
        $checklist = $this->getMockBuilder('Fornaza\Domain\Entities\Checklist')
                          ->disableOriginalConstructor()
                          ->getMock();

        $step = new Step($checklist, 'Test Step');
        $repository = $this->getRepositoryMock($step);

        $repository->expects($this->once())
                   ->method('save')
                   ->with($this->callback(function($step) {
                        return $step->isCompleted();
                   }));

        $useCase = new CompleteStep($repository);

        $command = new CompleteStepCommand(1);
        $useCase->execute($command);
    }

    public function test_complete_inexistent_step()
    {
        $this->setExpectedException('DomainException');

        $repository = $this->getRepositoryMock(null);

        $useCase = new CompleteStep($repository);

        $command = new CompleteStepCommand(1);
        $useCase->execute($command);
    }
}
