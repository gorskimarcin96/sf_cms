<?php

namespace App\Tests\App\Twig;

use App\Twig\Navigation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class NavigationTest extends TestCase
{
    public function testGetMenu(): void
    {
        $router = $this->createMock(UrlGeneratorInterface::class);
        $router->expects($this->any())
            ->method('generate')
            ->willReturnCallback(fn(string $routeName): string => "/$routeName");

        $translator = $this->createMock(TranslatorInterface::class);
        $translator->expects($this->any())
            ->method('trans')
            ->willReturnCallback(fn(string $routeName): string => ucfirst($routeName));

        $request = new Request();
        $request->attributes->set('_route', 'about me');
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->any())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $navigation = new Navigation($router, $translator, $requestStack);


        $this->assertSame([
            ['url' => '/homepage', 'name' => 'Homepage', 'active' => false],
            ['url' => '/contact', 'name' => 'Contact', 'active' => false],
            ['url' => '/about me', 'name' => 'About me', 'active' => true],
            ['url' => '/curriculum vitae', 'name' => 'Curriculum vitae', 'active' => false],
        ], $navigation->getMenu());
    }
}
