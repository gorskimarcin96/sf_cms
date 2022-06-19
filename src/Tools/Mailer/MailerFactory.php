<?php

namespace App\Tools\Mailer;

use App\Repository\ArchiveEmailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

class MailerFactory
{
    public const TEST_TYPE = 'test';
    public const APELINIA_TYPE = 'apelinia';

    public function __construct(private ApeliniaMail $apeliniaMail)
    {
    }

    public function create(string $from, array $to, string $type): array
    {
        $email = new TemplatedEmail();

        switch ($type) {
            case self::TEST_TYPE:
                $email
                    ->priority(Email::PRIORITY_HIGH)
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->htmlTemplate('emails/test.html.twig');
                break;
            case self::APELINIA_TYPE:
                $email = $this->apeliniaMail->create();
                break;
            default:
                throw new MailerWrongTypeException($type);
        }

        $email->from($from);

        foreach ($to as $toEmail) {
            $emails[] = $email->to($toEmail);
        }

        return $emails ?? [];
    }
}
