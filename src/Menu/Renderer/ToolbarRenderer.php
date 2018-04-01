<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Menu\Renderer;

use Knp\Menu\ItemInterface;

final class ToolbarRenderer extends BaseRenderer
{
    protected function renderList(ItemInterface $item, array $attributes, array $options): string
    {
        $html = '<v-toolbar '.$this->buildComponentConfig().'>';
        $html .= $this->renderChildren($item, $options);
        $html .= '</v-toolbar>';

        return $html;
    }

    private function renderChildren(ItemInterface $item, array $options)
    {
        // render children with a depth - 1
        if (null !== $options['depth']) {
            $options['depth'] = $options['depth'] - 1;
        }

        if (null !== $options['matchingDepth'] && $options['matchingDepth'] > 0) {
            $options['matchingDepth'] = $options['matchingDepth'] - 1;
        }

        $html = '<v-toolbar-items class="hidden-sm-and-down">';
        foreach ($item->getChildren() as $child) {
            $html .= $this->renderItem($child, $options);
        }
        $html .= '</v-toolbar-items>';

        return $html;
    }
}