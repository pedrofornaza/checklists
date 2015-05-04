<?php

namespace Fornaza\Domain\Entities;

class ChecklistTest extends \PHPUnit_Framework_TestCase
{
    private function getChecklistInstance()
    {
        $name = 'Test Checklist';
        $checklist = new Checklist($name);

        return $checklist;
    }

    private function getStepMock()
    {
        $step = $this->getMockBuilder('Fornaza\Domain\Entities\Step')
                     ->disableOriginalConstructor()
                     ->getMock();

        return $step;
    }

    public function test_checklist_must_have_a_name()
    {
        $checklist = $this->getChecklistInstance();

        $this->assertEquals('Test Checklist', $checklist->getName());
    }

    public function test_checklist_can_have_steps()
    {
        $checklist = $this->getChecklistInstance();

        $step = $checklist->addStep('Test Step');

        $this->assertContainsOnly($step, $checklist->getSteps());
    }

    public function test_checklist_can_complete_without_steps()
    {
        $checklist = $this->getChecklistInstance();

        $checklist->complete();

        $this->assertTrue($checklist->isCompleted());
    }

    public function test_checklist_cannot_complete_if_step_is_not_completed()
    {
        $this->setExpectedException('DomainException');

        $checklist = $this->getChecklistInstance();

        $checklist->addStep('Test Step');

        $checklist->complete();
    }

    public function test_checklist_can_be_complete_if_step_is_completed()
    {
        $checklist = $this->getChecklistInstance();

        $step = $checklist->addStep('Test Step');
        $step->complete();

        $checklist->complete();

        $this->assertTrue($checklist->isCompleted());
    }

    public function test_checklist_completion_rate_should_be_100_without_steps()
    {
        $checklist = $this->getChecklistInstance();

        $this->assertEquals(100, $checklist->getCompletionRate());
    }

    public function test_checklist_completion_rate_should_be_0_if_step_is_not_completed()
    {
        $checklist = $this->getChecklistInstance();

        $checklist->addStep('Test Step');

        $this->assertEquals(0, $checklist->getCompletionRate());
    }

    public function test_checklist_completion_rate_should_be_100_if_step_is_completed()
    {
        $checklist = $this->getChecklistInstance();

        $step = $checklist->addStep('Test Step');
        $step->complete();

        $this->assertEquals(100, $checklist->getCompletionRate());
    }

    public function test_checklist_completion_rate_should_be_50_if_one_step_is_completed_and_other_dont()
    {
        $checklist = $this->getChecklistInstance();

        $step = $checklist->addStep('Test Step 1');
        $step->complete();

        $checklist->addStep('Test Step 2');

        $this->assertEquals(50, $checklist->getCompletionRate());
    }
}
