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

final class SystembarRenderer extends BaseRenderer
{
    protected function renderList(ItemInterface $item, array $attributes, array $options): string
    {
        $html = '<v-system-bar'.$this->buildComponentConfig().'>';

        foreach ($item->getChildren() as $child) {
            $html .= $this->renderIcon($child->getName(), $attributes);
        }

        $html .= '</v-system-bar>';

        return $html;
    }
}
