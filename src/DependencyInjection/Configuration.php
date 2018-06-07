<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\DependencyInjection;

use Knp\Bundle\MenuBundle\KnpMenuBundle;
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
        $this->addMenuSection($root);

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

        $setOptionsConfig(
            $node
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

    private function addMenuSection(ArrayNodeDefinition $children)
    {
        $node = $children
                ->children()
                    ->arrayNode('menu')
                    ->info('Enabled integration with knplabs/knp-mnu-bundle. This setting is automatically enabled when the knplabs/knp-mnu-bundle is installed.');

        if (class_exists(KnpMenuBundle::class)) {
            $node->canBeDisabled();
        } else {
            $node->canBeEnabled();
        }

        $node->children()
            ->arrayNode('translate')
                ->canBeEnabled()
                ->children()
                    ->scalarNode('locale')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('domain')
                        ->defaultValue('messages')
                    ->end()
                ->end()
            ->end()
            ->arrayNode('toolbar')
                ->children()
                    ->booleanNode('absolute')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('app')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('card')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('clipped_left')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('clipped_right')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('color')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('dark')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('dense')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('extended')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('extension_height')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('fixed')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('flat')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('floating')
                        ->defaultNull()
                    ->end()
                    ->integerNode('height')
                    ->end()
                    ->scalarNode('inverted_scroll')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('light')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('manual_scroll')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('prominent')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('scroll_off_screen')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('scroll_target')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('scroll_toolbar_off_screen')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('tabs')
                        ->defaultNull()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('systembar')
                ->children()
                    ->booleanNode('absolute')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('app')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('color')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('dark')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('fixed')
                        ->defaultNull()
                    ->end()
                    ->integerNode('height')
                    ->end()
                    ->booleanNode('light')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('lights_out')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('status')
                        ->defaultNull()
                    ->end()
                    ->booleanNode('window')
                        ->defaultNull()
                    ->end()
                ->end()
            ->end()
            ;
    }
}
