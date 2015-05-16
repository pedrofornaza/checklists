<?php

namespace Fornaza\Domain\Commands;

class ArchiveChecklist
{
    public $checklistId;

    public function __construct($checklistId)
    {
        $this->checklistId = $checklistId;
    }
}
