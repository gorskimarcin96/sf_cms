<?php

namespace App\Utils;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FrontendData
{
    public function __construct(private UrlGeneratorInterface $router, private TranslatorInterface $translator)
    {
    }

    public function getMenu(): array
    {
        foreach (['homepage', 'contact', 'curriculum vitae'] as $navElement) {
            $nav[$this->router->generate($navElement)] = $this->translator->trans($navElement);
        }

        return $nav;
    }
}
