<?php

namespace App\MessageHandler;

use App\Message\SendTextInMessenger;
use App\Tools\Crawler\Facebook\Facebook;
use App\Tools\Task\Messenger\MessengerManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendTextInMessengerHandler implements MessageHandlerInterface
{
    public function __construct(private MessengerManager $messengerManager)
    {
    }

    public function __invoke(SendTextInMessenger $message)
    {
        $this->messengerManager->createClient();
        $this->messengerManager->login(
            $message->getLogin(),
            $message->getPassword(),
            Facebook::MESSENGER_URL
        );
        $this->messengerManager->sendTextToUserUrl(
            $message->getText(),
            $message->getUserUrl()
        );
        unset($this->messengerManager);
    }
}
