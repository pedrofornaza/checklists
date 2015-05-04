<?php

namespace Fornaza\Domain\Entities;

class StepTest extends \PHPUnit_Framework_TestCase
{
    private function getStepInstance()
    {
        $checklist = $this->getMockBuilder('Fornaza\Domain\Entities\Checklist')
                          ->disableOriginalConstructor()
                          ->getMock();

        $description = 'This step must be completed.';
        $step = new Step($checklist, $description);

        return $step;
    }

    public function test_step_must_have_a_description()
    {
        $step = $this->getStepInstance();

        $this->assertEquals('This step must be completed.', $step->getDescription());
    }

    public function test_step_can_be_done()
    {
        $step = $this->getStepInstance();

        $step->complete();

        $this->assertTrue($step->isCompleted());
    }
}
