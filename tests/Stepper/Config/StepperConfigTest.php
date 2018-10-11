<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Test\Stepper\Config;

use SolidWorx\VuetifyBundle\Stepper\Config\StepperConfig;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class StepperConfigTest extends TestCase
{
    public function testConstructorIsFinal()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessageRegExp(sprintf('#Call to private %s::__construct\(\)#', preg_quote(StepperConfig::class)));
        new StepperConfig();
    }

    public function testItCreatesAConfigWithDefaultValues()
    {
        $config = StepperConfig::create();

        $this->assertFalse($config->vertical);
        $this->assertFalse($config->nonLinear);
        $this->assertFalse($config->altLabels);
        $this->assertSame('light', $config->theme);
    }

    public function testItCreatesAConfigWithSpecifiedValues()
    {
        $config = StepperConfig::create([
            'vertical' => true,
            'altLabels' => true
        ]);

        $this->assertTrue($config->vertical);
        $this->assertFalse($config->nonLinear);
        $this->assertTrue($config->altLabels);
        $this->assertSame('light', $config->theme);
    }

    public function testItOnlyAcceptsValidTehemes()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage('The option "theme" with value "foobar" is invalid. Accepted values are: "light", "dark".');
        StepperConfig::create(['theme' => 'foobar']);
    }

    public function testItThrowsWhenSettingInvalidOptions()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The option "altLabels" with value "foobar" is expected to be of type "bool", but is of type "string"');
        $config = StepperConfig::create();
        $config->altLabels = 'foobar';
    }

    public function testItThrowsWhenSettingInvalidTheme()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The option "theme" with value "foobar" is invalid. Accepted values are: "light", "dark".');
        $config = StepperConfig::create();
        $config->theme = 'foobar';
    }

    public function testItCanSetTheOptions()
    {
        $config = StepperConfig::create();

        $config->theme = 'dark';
        $config->vertical = true;
        $config->nonLinear = true;
        $config->altLabels = true;

        $this->assertTrue($config->vertical);
        $this->assertTrue($config->nonLinear);
        $this->assertTrue($config->altLabels);
        $this->assertSame('dark', $config->theme);
    }
}
