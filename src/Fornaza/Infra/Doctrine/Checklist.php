<?php

namespace Fornaza\Infra\Doctrine;

use Doctrine\ORM\EntityRepository as DoctrineRepository;
use Fornaza\Domain\Entities\Checklist as ChecklistEntity;
use Fornaza\Domain\Repositories\Checklist as ChecklistRepository;

class Checklist extends DoctrineRepository implements ChecklistRepository
{
    public function save(ChecklistEntity $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
