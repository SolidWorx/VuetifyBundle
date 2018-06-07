<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Twig\Extension;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ElementAttributesExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('v_attr', [$this, 'attributes'], ['needs_environment' => true, 'is_safe' => ['html_attr']]),
        ];
    }

    /**
     * @param Environment $twig
     * @param array       $attrs
     *
     * @return string
     * @throws \Twig_Error_Runtime
     */
    public function attributes(Environment $twig, array $attrs): string
    {
        $attr = [];

        foreach ($attrs as $name => $value) {
            if (is_bool($value)) {
                $attr[] = ':'.$name.'="'.($value ? 'true' : 'false').'"';
            } else {
                $attr[] = $name.'="'.twig_escape_filter($twig, $value, 'html_attr').'"';
            }
        }

        return implode(' ', $attr);
    }
}
