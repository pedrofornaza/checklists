<?php

namespace Fornaza\Domain\Entities;

use DomainException;
use InvalidArgumentException;

class Checklist
{
    private $id;
    private $name;
    private $steps;
    private $completed;

    public function __construct($name)
    {
        $this->setName($name);
        $this->steps = array();
        $this->completed = false;
    }

    public function getId()
    {
        return $this->id;
    }

    private function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addStep($stepDescription)
    {
        $step = new Step($this, $stepDescription);
        $this->steps[] = $step;

        return $step;
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function complete()
    {
        foreach ($this->steps as $step) {
            if ( ! $step->isCompleted()) {
                throw new DomainException('The checklist cannot be completed until all the steps is done.');
            }
        }

        $this->completed = true;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    public function getCompletionRate()
    {
        if (count($this->steps) == 0) {
            return 100;
        }

        $rate = 0;
        $stepRate = 100 / count($this->steps);

        foreach ($this->steps as $step) {
            if ($step->isCompleted()) {
                $rate += $stepRate;
            }
        }

        return $rate;
    }
}
