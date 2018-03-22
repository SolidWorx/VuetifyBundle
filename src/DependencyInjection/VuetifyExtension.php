<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\DependencyInjection;

use SolidWorx\VuetifyBundle\Twig\Extension\VuetifyAlertExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class VuetifyExtension extends Extension
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));

        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader->load('services.xml');

        if ($config['menu']['enabled']) {
            $loader->load('menu.xml');
            if (isset($config['menu']['toolbar'])) {
                $container->getDefinition('solid_worx_vuetify.menu_renderer.vuetify_toolbar_renderer')
                    ->replaceArgument(3, $config['menu']['toolbar']);
            }
        }

        $container->getDefinition(VuetifyAlertExtension::class)->addArgument($config['alert']);
    }

    public function getAlias(): string
    {
        return 'vuetify';
    }
}