<?php

namespace Fornaza\Domain\Entities;

class ChecklistTest extends \PHPUnit_Framework_TestCase
{
    private function getChecklistInstance()
    {
        $name = 'Test Checklist';
        $checklist = new Checklist($name, ['Step Test']);

        return $checklist;
    }

    private function completeSteps($checklist)
    {
        $steps = $checklist->getSteps();
        foreach ($steps as $step) {
            $step->complete();
        }
    }

    public function test_checklist_must_have_a_name()
    {
        $checklist = $this->getChecklistInstance();

        $this->assertEquals('Test Checklist', $checklist->getName());
    }

    public function test_checklist_must_have_steps()
    {
        $this->setExpectedException('DomainException');

        $checklist = new Checklist('Test Checklist', []);
    }

    public function test_checklist_is_completed_if_step_is_completed()
    {
        $checklist = $this->getChecklistInstance();

        $this->completeSteps($checklist);

        $this->assertTrue($checklist->isCompleted());
    }

    public function test_checklist_can_complete_all_steps()
    {
        $checklist = $this->getChecklistInstance();

        $checklist->complete();

        $steps = $checklist->getSteps();
        foreach ($steps as $step) {
            $this->assertTrue($step->isCompleted());
        }
    }

    public function test_checklist_completion_rate_should_be_0_if_step_is_not_completed()
    {
        $checklist = $this->getChecklistInstance();

        $this->assertEquals(0, $checklist->getCompletionRate());
    }

    public function test_checklist_completion_rate_should_be_100_if_step_is_completed()
    {
        $checklist = $this->getChecklistInstance();

        $this->completeSteps($checklist);

        $this->assertEquals(100, $checklist->getCompletionRate());
    }

    public function test_checklist_completion_rate_should_be_50_if_one_step_is_completed_and_other_dont()
    {
        $checklist = $this->getChecklistInstance();

        $this->completeSteps($checklist);

        $checklist->addStep('Test Step 2');

        $this->assertEquals(50, $checklist->getCompletionRate());
    }

    public function test_checklist_can_be_archived()
    {
        $checklist = $this->getChecklistInstance();

        $checklist->archive();

        $this->assertTrue($checklist->isArchived());
    }
}
