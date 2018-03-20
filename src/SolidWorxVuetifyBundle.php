<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle;

use SolidWorx\VuetifyBundle\DependencyInjection\VuetifyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SolidWorxVuetifyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new VuetifyExtension();
    }
}