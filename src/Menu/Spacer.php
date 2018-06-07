<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Menu;

use Knp\Menu\MenuItem;

final class Spacer extends MenuItem
{
    public function __construct()
    {
        // noop
    }

    public function getName()
    {
        return 'spacer_'.bin2hex(random_bytes(4));
    }

    public function getLabel()
    {
        return '<v-spacer></v-spacer>';
    }
}
