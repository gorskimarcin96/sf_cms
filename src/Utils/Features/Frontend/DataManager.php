<?php

namespace App\Utils\Features\Frontend;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DataManager
{
    public function __construct(
        private UrlGeneratorInterface $router,
        private TranslatorInterface $translator,
        private RequestStack $requestStack
    ) {
    }

    public function getMenu(): array
    {
        $activeRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');

        foreach (['homepage', 'contact', 'curriculum vitae'] as $navElement) {
            $nav[] = [
                'url'    => $this->router->generate($navElement),
                'name'   => $this->translator->trans($navElement),
                'active' => $activeRoute === $navElement,
            ];
        }

        return $nav;
    }
}
