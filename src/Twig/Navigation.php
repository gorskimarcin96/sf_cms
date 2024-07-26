<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class Navigation
{
    public function __construct(
        private UrlGeneratorInterface $router,
        private TranslatorInterface $translator,
        private RequestStack $requestStack,
    ) {
    }

    /** @return string[][]|bool[][] */
    public function getMenu(): array
    {
        $activeRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');

        foreach (['homepage', 'contact', 'about me', 'curriculum vitae'] as $routeName) {
            $nav[] = [
                'url' => $this->router->generate($routeName),
                'name' => $this->translator->trans($routeName),
                'active' => $activeRoute === $routeName,
            ];
        }

        return $nav;
    }
}
