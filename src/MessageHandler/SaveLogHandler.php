<?php

namespace App\MessageHandler;

use App\Message\SaveLog;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveLogHandler implements MessageHandlerInterface
{
    public function __construct(private LoggerInterface $queueLogger)
    {
    }

    public function __invoke(SaveLog $message)
    {
        $this->queueLogger->notice($message->getText());
    }
}
