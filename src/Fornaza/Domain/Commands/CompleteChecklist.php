<?php

namespace Fornaza\Domain\Commands;

class CompleteChecklist
{
    public $checklistId;

    public function __construct($checklistId)
    {
        $this->checklistId = $checklistId;
    }
}
