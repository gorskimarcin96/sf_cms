<?php

namespace App\MessageHandler;

use App\Mailer\MailerFactory;
use App\Message\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MailerHandler implements MessageHandlerInterface
{
    public function __construct(private MailerFactory $mailerFactory, private MailerInterface $mailer)
    {
    }

    public function __invoke(Mailer $message)
    {
        $emails = $this->mailerFactory->create($message->getFrom(), $message->getTo(), $message->getType());

        foreach ($emails as $email) {
            $this->mailer->send($email);
        }
    }
}
