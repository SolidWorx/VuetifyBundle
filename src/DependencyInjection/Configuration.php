<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $types = [
        'success',
        'info',
        'error',
        'warning'
    ];

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('vuetify');

        $this->addAlertSection($root);

        return $builder;
    }

    private function addAlertSection(ArrayNodeDefinition $children)
    {
        $node = $children
                ->children()
                    ->arrayNode('alert')
                    ->addDefaultsIfNotSet();

        $setOptionsConfig = function (ArrayNodeDefinition $node) {
            return $node
                ->children()
                    ->booleanNode('dismissible')
                        ->info('Specifies that the Alert can be closed. The `v-model` option must be set when this is `true` in order for the alert to be dismissed')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('outline')
                        ->info('Alert will have an outline')
                        ->defaultFalse()
                    ->end()
                    ->scalarNode('color')
                        ->info('Applies specified color to the control')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('mode')
                        ->info('Sets the transition mode')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('transition')
                        ->info('Sets the component transition. Can be one of the built in transitions or your own')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('origin')
                        ->info('Sets the transition origin')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('icon')
                        ->info('Designates a specific icon')
                        ->defaultNull()
                    ->end()
                ->end()
            ->end();
        };

        $setOptionsConfig($node
            ->children()
                ->arrayNode('default')
                ->info('Sets global default options for each alert. Options per alert type can be overwritten in the `types` config.')
                )
            ->end()
        ->end()
        ;

        $types = $node
            ->children()
                ->arrayNode('types')
                    ->info('Sets the default config per alert type. This will overwrite any global config for a specific alert type')
                    ->children();

        foreach ($this->types as $type) {
            $setOptionsConfig($types->arrayNode($type));
        }
    }
}