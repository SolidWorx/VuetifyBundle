<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Test\Menu\Renderer;

use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuFactory;
use PHPUnit\Framework\TestCase;
use SolidWorx\VuetifyBundle\Menu\Renderer\SystembarRenderer;

class SystembarRendererTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException|\PHPUnit\Framework\Exception|\ReflectionException|\Exception
     */
    public function testRender()
    {
        $renderer = new SystembarRenderer($this->createMock(MatcherInterface::class));

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('home');
        $menu->addChild('phone');

        $this->assertSame(
            '<v-system-bar ><v-icon >home</v-icon><v-icon >phone</v-icon></v-system-bar>',
            $renderer->render($menu)
        );
    }

    public function testRenderWithDefaultOptions()
    {
        $renderer = new SystembarRenderer($this->createMock(MatcherInterface::class), [], null, ['status' => true]);

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('home');
        $menu->addChild('phone');

        $this->assertSame(
            '<v-system-bar :status="true"><v-icon >home</v-icon><v-icon >phone</v-icon></v-system-bar>',
            $renderer->render($menu)
        );
    }
}
