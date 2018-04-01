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
use SolidWorx\VuetifyBundle\Menu\MenuTranslator;
use SolidWorx\VuetifyBundle\Menu\Renderer\ToolbarRenderer;
use SolidWorx\VuetifyBundle\Menu\Spacer;
use Symfony\Component\Translation\TranslatorInterface;

class ToolbarRendererTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException|\PHPUnit\Framework\Exception|\ReflectionException|\Exception
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
            '<v-toolbar><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="" class="first">Home</v-btn><v-btn flat href="">Disclaimer</v-btn><v-menu><template slot="activator"><v-btn flat class="last">About Me <v-icon>arrow_drop_down</v-icon></v-btn></template><v-list><v-list-tile href=""><v-list-tile-title>Edit profile</v-list-tile-title></v-list-tile></v-list></v-menu></v-toolbar-items></v-toolbar>',
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

    public function testRenderWithOneSpacer()
    {
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class), [], null, ['dense' => true]);

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild(new Spacer());
        $menu->addChild('Home');
        $menu->addChild('Disclaimer');
        $menu->addChild('About Me');
        $menu['About Me']->addChild('Edit profile');

        $this->assertSame(
            '<v-toolbar :dense="true"><v-spacer></v-spacer><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="">Home</v-btn><v-btn flat href="">Disclaimer</v-btn><v-menu><template slot="activator"><v-btn flat class="last">About Me <v-icon>arrow_drop_down</v-icon></v-btn></template><v-list><v-list-tile href=""><v-list-tile-title>Edit profile</v-list-tile-title></v-list-tile></v-list></v-menu></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }

    public function testRenderWithMultipleSpacers()
    {
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class), [], null, ['dense' => true]);

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild(new Spacer());
        $menu->addChild('Home');
        $menu->addChild('Disclaimer');
        $menu->addChild(new Spacer());
        $menu->addChild('About Me');
        $menu['About Me']->addChild('Edit profile');

        $this->assertSame(
            '<v-toolbar :dense="true"><v-spacer></v-spacer><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="">Home</v-btn><v-btn flat href="">Disclaimer</v-btn></v-toolbar-items><v-spacer></v-spacer><v-toolbar-items class="hidden-sm-and-down"><v-menu><template slot="activator"><v-btn flat class="last">About Me <v-icon>arrow_drop_down</v-icon></v-btn></template><v-list><v-list-tile href=""><v-list-tile-title>Edit profile</v-list-tile-title></v-list-tile></v-list></v-menu></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }

    public function testRenderWithIcon()
    {
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class), [], null, ['dense' => true]);

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('Home', ['extras' => ['icon' => 'home']]);

        $this->assertSame(
            '<v-toolbar :dense="true"><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="" class="first last"><v-icon >home</v-icon> Home</v-btn></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }

    public function testRenderWithTranslator()
    {
        $translator = $this->createMock(TranslatorInterface::class);
        $renderer = new ToolbarRenderer($this->createMock(MatcherInterface::class), [], null, ['dense' => true]);
        $renderer->setTranslator(new MenuTranslator($translator, 'menu', 'af_ZA'));

        $translator->expects($this->once())
            ->method('trans')
            ->with('Home', [], 'menu', 'af_ZA')
            ->willReturn('Huis');

        $menu = (new MenuFactory())->createItem('root');
        $menu->addChild('Home');

        $this->assertSame(
            '<v-toolbar :dense="true"><v-toolbar-items class="hidden-sm-and-down"><v-btn flat href="" class="first last">Huis</v-btn></v-toolbar-items></v-toolbar>',
            $renderer->render($menu)
        );
    }
}
