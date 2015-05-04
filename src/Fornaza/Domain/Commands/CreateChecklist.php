<?php

namespace Fornaza\Domain\Commands;

class CreateChecklist
{
    public $checklistName;
    public $stepsDescription;

    public function __construct($checklistName, $stepsDescription = array())
    {
        $this->checklistName = $checklistName;
        $this->stepsDescription = $stepsDescription;
    }
}
