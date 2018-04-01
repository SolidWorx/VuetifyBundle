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
use SolidWorx\VuetifyBundle\Menu\Spacer;

final class ToolbarRenderer extends BaseRenderer
{
    protected function renderList(ItemInterface $item, array $attributes, array $options): string
    {
        $html = '<v-toolbar'.$this->buildComponentConfig().'>';
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

        $html = '';
        $items = [];
        foreach ($item->getChildren() as $child) {
            if ($child instanceof Spacer) {
                if (count($items) > 0) {
                    $html .= $this->generateItemHtml($items);
                    $items = [];
                }

                $html .= $child->getLabel();
            } else {
                $items[] = $this->renderItem($child, $options);
            }
        }

        if (count($items) > 0) {
            $html .= $this->generateItemHtml($items);
        }

        return $html;
    }

    private function generateItemHtml(array $items): string
    {
        $html = '<v-toolbar-items class="hidden-sm-and-down">';
        $html .= implode('', $items);
        $html .= '</v-toolbar-items>';

        return $html;
    }
}