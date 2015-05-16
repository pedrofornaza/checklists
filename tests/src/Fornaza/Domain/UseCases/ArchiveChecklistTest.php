<?php

namespace Fornaza\Domain\UseCases;

use Fornaza\Domain\Commands\ArchiveChecklist as ArchiveChecklistCommand;
use Fornaza\Domain\Entities\Checklist;
use Fornaza\Domain\Entities\Step;

class ArchiveChecklistTest extends \PHPUnit_Framework_TestCase
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

    public function test_archive_valid_checklist()
    {
        $checklist = $this->getMockBuilder('Fornaza\Domain\Entities\Checklist')
                          ->disableOriginalConstructor()
                          ->getMock();

        $checklist->expects($this->once())
                  ->method('archive');

        $repository = $this->getRepositoryMock($checklist);

        $repository->expects($this->once())
                   ->method('save')
                   ->with($checklist);

        $useCase = new ArchiveChecklist($repository);

        $command = new ArchiveChecklistCommand(1);
        $useCase->execute($command);
    }

    public function test_archive_non_existent_checklist()
    {
        $this->setExpectedException('DomainException');

        $repository = $this->getRepositoryMock(null);
        $useCase = new ArchiveChecklist($repository);

        $command = new ArchiveChecklistCommand(1);
        $useCase->execute($command);
    }
}
