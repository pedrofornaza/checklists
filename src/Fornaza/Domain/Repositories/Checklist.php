<?php

namespace Fornaza\Domain\Repositories;

use Fornaza\Domain\Entities\Checklist as ChecklistEntity;

interface Checklist
{
    public function findAll();
    public function findAllArchived();
    public function find($id);
    public function save(ChecklistEntity $entity);
}
