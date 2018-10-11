<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Stepper\Config;

use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @property bool   $vertical
 * @property bool   $nonLinear
 * @property bool   $altLabels
 * @property string $theme
 */
final class StepperConfig
{
    private const THEME_LIGHT = 'light';

    private const THEME_DARK = 'dark';

    private $defaults = [
        'nonLinear' => false,
        'altLabels' => false,
        'theme' => self::THEME_LIGHT,
        'vertical' => false,
    ];

    private $options = [];

    final private function __construct(array $options)
    {
        $this->options = $this->validate($options);
    }

    public static function create(array $options = []): self
    {
        return new self($options);
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Option "%s" is invalid on "%s". Valid options are: %s', $name, self::class, implode(', ', array_keys($this->options))));
        }

        $this->options[$name] = $this->validate([$name => $value])[$name];
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Option "%s" is invalid on "%s". Valid options are: %s', $name, self::class, implode(', ', array_keys($this->options))));
        }

        return $this->options[$name];
    }

    /**
     * @throws ExceptionInterface
     */
    private function validate(array $options): array
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults($this->defaults);

        $resolver->setAllowedTypes('altLabels', 'bool');
        $resolver->setAllowedTypes('theme', 'string');
        $resolver->setAllowedTypes('nonLinear', 'bool');
        $resolver->setAllowedTypes('vertical', 'bool');

        $resolver->setAllowedValues('theme', [self::THEME_LIGHT, self::THEME_DARK]);

        return $resolver->resolve($options);
    }
}