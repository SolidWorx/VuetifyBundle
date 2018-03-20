<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Twig\Extension;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VuetifyAlertExtension extends AbstractExtension
{
    private $options;

    private $defaultConfig = [];

    private $validOptions = [
        'color' => 'string',
        'dismissible' => 'bool',
        'icon' => 'string',
        'mode' => 'string',
        'origin' => 'string',
        'outline' => 'bool',
        'transition' => 'string',
        'v-model' => 'string',
    ];

    public function __construct(array $defaultConfig = [])
    {
        $this->defaultConfig = $defaultConfig;

        $this->options = new OptionsResolver();
        $this->options->setDefined(array_keys($this->validOptions));

        array_walk($this->validOptions, function ($type, $option) {
            $this->options->setAllowedTypes($option, $type);
        });
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('v_alert', [$this, 'alert'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function alert(Environment $twig, string $message, string $type, array $options = [])
    {
        $options = array_merge(array_filter($this->defaultConfig['default'] ?? []), array_filter($this->defaultConfig['types'][$type] ?? []), $this->options->resolve($options));

        $attr = [];

        foreach ($options as $name => $value) {
            if (is_bool($value)) {
                $attr[] = ':'.$name.'="'.($value ? 'true' : 'false').'"';
            } else {
                $attr[] = $name.'="'.twig_escape_filter($twig, $value, 'html_attr').'"';
            }
        }

        return '<v-alert type="'.$type.'" :value="true" '.implode(' ', $attr).'>'.$message.'</v-alert>';
    }
}