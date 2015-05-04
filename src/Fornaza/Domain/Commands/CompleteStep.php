<?php

namespace Fornaza\Domain\Commands;

class CompleteStep
{
    public $stepId;

    public function __construct($stepId)
    {
        $this->stepId = $stepId;
    }
}
