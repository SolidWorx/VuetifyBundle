<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Stepper;

use SolidWorx\VuetifyBundle\Stepper\Config\StepperConfig;

final class Stepper
{
    private const DEFAULT_PRIORITY = 0;

    /**
     * @var StepInterface[]
     */
    private $steps = [];

    /**
     * @var StepperConfig
     */
    private $options;

    /**
     * @var StepInterface[]
     */
    private $sorted = [];

    public function __construct(?StepperConfig $options = null)
    {
        $this->options = $options ?? StepperConfig::create();
    }

    public function addStep(StepInterface $step, int $priority = self::DEFAULT_PRIORITY): void
    {
        $this->steps[$priority][] = $step;
        $this->sorted = [];
    }

    public function getOptions(): StepperConfig
    {
        return $this->options;
    }

    public function getSteps()
    {
        if ($this->sorted) {
            return $this->sorted;
        }

        return $this->sortSteps();
    }

    private function sortSteps(): array
    {
        $unsortedSteps = $this->steps;
        ksort($unsortedSteps);
        $steps = [];

        foreach ($unsortedSteps as $step) {
            $steps = array_merge($steps, $step);
        }

        return $this->sorted = $steps;
    }
}
