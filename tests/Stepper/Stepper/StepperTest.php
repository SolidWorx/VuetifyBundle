<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Test\Stepper;

use PHPUnit\Framework\TestCase;
use SolidWorx\VuetifyBundle\Stepper\Config\StepperConfig;
use SolidWorx\VuetifyBundle\Stepper\StepInterface;
use SolidWorx\VuetifyBundle\Stepper\Stepper;

class StepperTest extends TestCase
{
    public function testGetOptionsSetsDefaultValues()
    {
        $stepper = new Stepper();
        $this->assertInstanceOf(StepperConfig::class, $stepper->getOptions());
    }

    public function testAddStepsWithPriorities()
    {
        $step1 = $this->createMock(StepInterface::class);
        $step2 = $this->createMock(StepInterface::class);
        $step3 = $this->createMock(StepInterface::class);
        $step4 = $this->createMock(StepInterface::class);

        $stepper = new Stepper();
        $stepper->addStep($step1);
        $stepper->addStep($step2, 10);
        $stepper->addStep($step3, 20);
        $stepper->addStep($step4, 5);

        $this->assertSame([
            $step1,
            $step4,
            $step2,
            $step3,
        ], $stepper->getSteps());
    }
}
