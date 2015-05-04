<?php

namespace Fornaza\Infra\Doctrine;

use Doctrine\ORM\EntityRepository as DoctrineRepository;
use Fornaza\Domain\Entities\Step as StepEntity;
use Fornaza\Domain\Repositories\Step as StepRepository;

class Step extends DoctrineRepository implements StepRepository
{
    public function save(StepEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
