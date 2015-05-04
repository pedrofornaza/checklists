<?php

namespace Fornaza\Domain\Repositories;

use Fornaza\Domain\Entities\Step as StepEntity;

interface Step
{
    public function find($id);
    public function save(StepEntity $entity);
}
