<?php

namespace App\Tests\Utils\Features\Frontend;

use App\Utils\Features\Frontend\DataManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DataManagerTest extends TestCase
{
    public function testGetMenu()
    {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->method('generate')->will(
            $this->onConsecutiveCalls('/pl/', '/pl/kontakt', '/pl/curriculum-vitae')
        );

        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('trans')->will(
            $this->onConsecutiveCalls('strona główna', 'kontakt', 'curriculum vitae')
        );

        $parameterBag = $this->createMock(ParameterBag::class);
        $parameterBag->method('get')->will(
            $this->onConsecutiveCalls(true, false, false)
        );

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn(new Request([], [], ['_route' => 'homepage']));

        $dataManager = new DataManager($urlGenerator, $translator, $requestStack);

        $this->assertSame([
            [
                "url"    => "/pl/",
                "name"   => "strona główna",
                "active" => true,
            ], [
                "url"    => "/pl/kontakt",
                "name"   => "kontakt",
                "active" => false,
            ], [
                "url"    => "/pl/curriculum-vitae",
                "name"   => "curriculum vitae",
                "active" => false,
            ],
        ], $dataManager->getMenu());
    }
}