<?php

namespace App\EventListener;

use App\Utils\Counter\CounterManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class RouteEventSubscriber implements EventSubscriberInterface
{
    final public const LISTEN_ROUTERS_FOR_LOG = [
        '/pl/',
        '/pl/kontakt',
        '/pl/o-mnie',
        '/pl/curriculum-vitae',
        '/pl/file/CV_PL.pdf',
        '/en/',
        '/en/contact',
        '/en/about-me',
        '/en/curriculum-vitae',
        '/en/file/CV_EN.pdf',
    ];

    public function __construct(private CounterManager $counterManager)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $this->logVisitWebsite($event);
    }

    private function logVisitWebsite(RequestEvent $event): void
    {
        $requestUri = $event->getRequest()->getRequestUri();

        if (in_array($requestUri, static::LISTEN_ROUTERS_FOR_LOG)) {
            $this->counterManager->entry($requestUri);
        }
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }
}
