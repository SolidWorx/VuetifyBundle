<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Test\Twig\Extension;

use PHPUnit\Framework\TestCase;
use SolidWorx\VuetifyBundle\Twig\Extension\VuetifyAlertExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class VuetifyAlertExtensionTest extends TestCase
{
    /**
     * @dataProvider alertDataProvider
     */
    public function testAlert(string $message, string $type, array $options, array $defaultConfig, string $result)
    {
        $extension = new VuetifyAlertExtension($defaultConfig);

        $env = new Environment(new ArrayLoader());

        $this->assertSame(
            $result,
            $extension->alert($env, $message, $type, $options)
        );
    }

    public function alertDataProvider()
    {
        return [
            [
                'Test Alert',
                'success',
                [],
                [],
                '<v-alert type="success" :value="true" >Test Alert</v-alert>',
            ],
            [
                'Test Alert',
                'error',
                [],
                [],
                '<v-alert type="error" :value="true" >Test Alert</v-alert>',
            ],
            [
                'Test Alert',
                'info',
                [
                    'outline' => true,
                ],
                [],
                '<v-alert type="info" :value="true" :outline="true">Test Alert</v-alert>',
            ],
            [
                'Test Alert',
                'warning',
                [],
                [
                    'default' => [
                        'outline' => false,
                        'dismissiable' => true,
                    ],
                ],
                '<v-alert type="warning" :value="true" :dismissiable="true">Test Alert</v-alert>',
            ],
            [
                'Test Alert',
                'warning',
                [],
                [
                    'default' => [
                        'outline' => false,
                        'dismissiable' => true,
                    ],
                    'types' => [
                        'warning' => [
                            'outline' => true,
                        ],

                    ],
                ],
                '<v-alert type="warning" :value="true" :dismissiable="true" :outline="true">Test Alert</v-alert>',
            ],
            [
                'Test Alert',
                'warning',
                [
                    'icon' => 'three',
                ],
                [
                    'default' => [
                        'icon' => 'one',
                    ],
                    'types' => [
                        'warning' => [
                            'icon' => 'two',
                        ],

                    ],
                ],
                '<v-alert type="warning" :value="true" icon="three">Test Alert</v-alert>',
            ],
        ];
    }
}
