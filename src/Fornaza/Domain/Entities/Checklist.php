<?php

namespace Fornaza\Domain\Entities;

use DomainException;

class Checklist
{
    private $id;
    private $name;
    private $steps;
    private $archived;

    public function __construct($name, $steps)
    {
        $this->setName($name);
        $this->setSteps($steps);
        $this->archived = false;
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

    private function setSteps(array $steps)
    {
        $steps = array_filter($steps, function($step) {
            return $step != '';
        });

        if (empty($steps)) {
            throw new DomainException('A checklist must have steps.');
        }

        foreach ($steps as $step) {
            $this->addStep($step);
        }
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
            $step->complete();
        }
    }

    public function isCompleted()
    {
        $completed = true;

        foreach ($this->steps as $step) {
            if ( ! $step->isCompleted()) {
                $completed = false;
                break;
            }
        }

        return $completed;
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

    public function archive()
    {
        $this->archived = true;
    }

    public function isArchived()
    {
        return $this->archived;
    }
}
