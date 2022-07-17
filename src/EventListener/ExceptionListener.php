<?php

namespace App\EventListener;

use App\Tools\Integration\Dropbox\RefreshToken;
use GuzzleHttp\Exception\ClientException;
use Spatie\Dropbox\Exceptions\BadRequest;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __construct(private RefreshToken $refreshToken)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (
            $exception instanceof ClientException &&
            $exception->getCode() === 401 &&
            $exception->getResponse()->hasHeader('x-dropbox-request-id')
        ) {
            $this->refreshToken->refresh();
        } elseif ($exception instanceof BadRequest) {
            $this->refreshToken->refresh();
        }
    }
}
