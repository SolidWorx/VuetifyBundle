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
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\Renderer\Renderer;
use Knp\Menu\Renderer\RendererInterface;

class ToolbarRenderer extends Renderer implements RendererInterface
{
    protected $matcher;

    protected $defaultOptions = [];

    private $componentConfig = [];

    public function __construct(MatcherInterface $matcher, array $defaultOptions = [], ?string $charset = null, array $componentConfig = [])
    {
        $this->matcher = $matcher;
        $this->defaultOptions = array_merge([
            'depth' => null,
            'matchingDepth' => null,
            'currentAsLink' => true,
            'currentClass' => 'btn--active',
            'ancestorClass' => 'current_ancestor',
            'firstClass' => 'first',
            'lastClass' => 'last',
            'compressed' => false,
            'allow_safe_labels' => false,
            'clear_matcher' => true,
            'leaf_class' => null,
            'branch_class' => null,
        ], $defaultOptions);
        $this->componentConfig = $componentConfig;

        parent::__construct($charset);
    }

    /**
     * {@inheritdoc}
     */
    public function render(ItemInterface $item, array $options = [])
    {
        $options = array_merge($this->defaultOptions, $options);

        $html = $this->renderList($item, $item->getChildrenAttributes(), $options);

        if ($options['clear_matcher']) {
            $this->matcher->clear();
        }

        return $html;
    }

    private function renderList(ItemInterface $item, array $attributes, array $options)
    {
        /**
         * Return an empty string if any of the following are true:
         *   a) The menu has no children eligible to be displayed
         *   b) The depth is 0
         *   c) This menu item has been explicitly set to hide its children
         */
        if (!$item->hasChildren() || 0 === $options['depth'] || !$item->getDisplayChildren()) {
            return '';
        }

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

    private function renderItem(ItemInterface $item, array $options): string
    {
        // if we don't have access or this item is marked to not be shown
        if (!$item->isDisplayed()) {
            return '';
        }

        // create an array than can be imploded as a class list
        $class = (array) $item->getAttribute('class');

        if ($this->matcher->isCurrent($item)) {
            $class[] = $options['currentClass'];
        } elseif ($this->matcher->isAncestor($item, $options['matchingDepth'])) {
            $class[] = $options['ancestorClass'];
        }

        if ($item->actsLikeFirst()) {
            $class[] = $options['firstClass'];
        }
        if ($item->actsLikeLast()) {
            $class[] = $options['lastClass'];
        }

        if ($item->hasChildren() && $options['depth'] !== 0) {
            if (null !== $options['branch_class'] && $item->getDisplayChildren()) {
                $class[] = $options['branch_class'];
            }
        } elseif (null !== $options['leaf_class']) {
            $class[] = $options['leaf_class'];
        }

        // retrieve the attributes and put the final class string back on it
        $attributes = $item->getAttributes();
        if (!empty($class)) {
            $attributes['class'] = implode(' ', $class);
        }

        $html = '';

        if ($item->hasChildren()) {
            $html .= '<v-menu>';
            $html .= '<template slot="activator">';
            $html .= $this->renderBtn($item, $options, $attributes);
            $html .= '</template>';
            $html .= '<v-list>';

            foreach ($item->getChildren() as $child) {
                $html .= '<v-list-tile href="'.$item->getUri().'"><v-list-tile-title>';

                $html .= $this->renderLabel($child, $options);

                $html .= '</v-list-tile-title></v-list-tile>';
            }

            $html .= '</v-list>';

            $html .= '</v-menu>';
        } else {
            $html .= $this->renderLink($item, $options, $attributes);
        }

        return $html;
    }

    private function buildComponentConfig(): string
    {
        $attr = [];

        foreach ($this->componentConfig as $name => $value) {

            if (null === $value) {
                continue;
            }

            if (is_bool($value)) {
                $attr[] = ':'.$name.'="'.($value ? 'true' : 'false').'"';
            } else {
                $attr[] = $name.'="'.$this->escape($value).'"';
            }
        }

        return implode(' ', $attr);
    }

    private function renderLink(ItemInterface $item, array $options, array $attributes): string
    {
        return sprintf('<v-btn flat href="%s"%s>%s</v-btn>', $this->escape($item->getUri()), $this->renderHtmlAttributes(array_merge($attributes, $item->getLinkAttributes())), $this->renderLabel($item, $options));
    }

    private function renderBtn(ItemInterface $item, array $options, array $attributes): string
    {
        return sprintf('<v-btn flat%s>%s <v-icon>arrow_drop_down</v-icon></v-btn>', $this->renderHtmlAttributes(array_merge($attributes, $item->getLinkAttributes())), $this->renderLabel($item, $options));
    }

    private function renderLabel(ItemInterface $item, array $options): string
    {
        if ($options['allow_safe_labels'] && $item->getExtra('safe_label', false)) {
            return $item->getLabel();
        }

        return $this->escape($item->getLabel());
    }
}