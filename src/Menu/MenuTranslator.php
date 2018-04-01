<?php

declare(strict_types=1);

/*
 * This file is part of the VuetifyBundle project.
 *
 * @author     Pierre du Plessis
 * @copyright  Copyright (c) SolidWorx <open-source@solidworx.co>
 */

namespace SolidWorx\VuetifyBundle\Menu;

use Symfony\Component\Translation\TranslatorInterface;

class MenuTranslator
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $domain;

    public function __construct(?TranslatorInterface $translator, ?string $domain, ?string $locale)
    {
        $this->translator = $translator;
        $this->locale = $locale;
        $this->domain = $domain;
    }

    public function trans(string $mssage, array $attributes = []): string
    {
        return $this->translator ? $this->translator->trans($mssage, $attributes, $this->domain, $this->locale) : $mssage;
    }
}