<?php

namespace Fornaza\Domain\Entities;

class Step
{
    private $id;
    private $checklist;
    private $description;
    private $completed;

    public function __construct(Checklist $checklist, $description)
    {
        $this->checklist = $checklist;
        $this->description = $description;
        $this->completed = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function complete()
    {
        $this->completed = true;
    }

    public function isCompleted()
    {
        return $this->completed;
    }
}
