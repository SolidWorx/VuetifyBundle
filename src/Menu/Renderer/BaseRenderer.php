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
use SolidWorx\VuetifyBundle\Menu\Divider;
use SolidWorx\VuetifyBundle\Menu\Spacer;

abstract class BaseRenderer extends Renderer implements RendererInterface
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

        /**
         * Return an empty string if any of the following are true:
         *   a) The menu has no children eligible to be displayed
         *   b) The depth is 0
         *   c) This menu item has been explicitly set to hide its children
         */
        if (!$item->hasChildren() || 0 === $options['depth'] || !$item->getDisplayChildren()) {
            $this->clearMatcher($options);

            return '';
        }

        $html = $this->renderList($item, $item->getChildrenAttributes(), $options);

        $this->clearMatcher($options);

        return $html;
    }

    abstract protected function renderList(ItemInterface $item, array $attributes, array $options): string;

    protected function renderItem(ItemInterface $item, array $options): string
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
                if ($child instanceof Divider) {
                    $html .= $child->getLabel();
                } else {
                    $html .= '<v-list-tile href="'.$child->getUri().'"><v-list-tile-title>';
                    $html .= $this->renderLabel($child, $options);
                    $html .= '</v-list-tile-title></v-list-tile>';
                }
            }

            $html .= '</v-list>';

            $html .= '</v-menu>';
        } else {
            $html .= $this->renderLink($item, $options, $attributes);
        }

        return $html;
    }

    protected function buildComponentConfig(): string
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

        return $attr ? ' '.implode(' ', $attr) : '';
    }

    protected function renderLink(ItemInterface $item, array $options, array $attributes): string
    {
        return sprintf('<v-btn flat href="%s"%s>%s</v-btn>', $this->escape($item->getUri()), $this->renderHtmlAttributes(array_merge($attributes, $item->getLinkAttributes())), $this->renderLabel($item, $options));
    }

    protected function renderBtn(ItemInterface $item, array $options, array $attributes): string
    {
        return sprintf('<v-btn flat%s>%s <v-icon>arrow_drop_down</v-icon></v-btn>', $this->renderHtmlAttributes(array_merge($attributes, $item->getLinkAttributes())), $this->renderLabel($item, $options));
    }

    protected function renderIcon(ItemInterface $item, array $options, array $attributes): string
    {
        return sprintf('<v-icon %s>%s</v-icon>', $this->renderHtmlAttributes(array_merge($attributes, $item->getLinkAttributes())), $this->renderLabel($item, $options));
    }

    protected function renderLabel(ItemInterface $item, array $options): string
    {
        if ($options['allow_safe_labels'] && $item->getExtra('safe_label', false)) {
            return $item->getLabel();
        }

        return $this->escape($item->getLabel());
    }

    private function clearMatcher(array $options): void
    {
        if ($options['clear_matcher']) {
            $this->matcher->clear();
        }
    }
}