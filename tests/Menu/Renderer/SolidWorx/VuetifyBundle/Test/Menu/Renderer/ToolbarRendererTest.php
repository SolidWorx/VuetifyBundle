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
use SolidWorx\VuetifyBundle\Menu\Renderer\ToolbarRenderer;

class ToolbarRendererTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function testRender()
    {
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class));

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('Home');
        $menu->addChild('Disclaimer');
        $menu->addChild('About Me');
        $menu['About Me']->addChild('Edit profile');

        $this->assertSame(
            '<v-toolbar ><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="" class="first">Home</v-btn><v-btn flat href="">Disclaimer</v-btn><v-menu><template slot="activator"><v-btn flat class="last">About Me <v-icon>arrow_drop_down</v-icon></v-btn></template><v-list><v-list-tile href=""><v-list-tile-title>Edit profile</v-list-tile-title></v-list-tile></v-list></v-menu></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }

    public function testRenderWithDefaultOptions()
    {
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class), [], null, ['dense' => true]);

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('Home');
        $menu->addChild('Disclaimer');
        $menu->addChild('About Me');
        $menu['About Me']->addChild('Edit profile');

        $this->assertSame(
            '<v-toolbar :dense="true"><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="" class="first">Home</v-btn><v-btn flat href="">Disclaimer</v-btn><v-menu><template slot="activator"><v-btn flat class="last">About Me <v-icon>arrow_drop_down</v-icon></v-btn></template><v-list><v-list-tile href=""><v-list-tile-title>Edit profile</v-list-tile-title></v-list-tile></v-list></v-menu></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }
}
