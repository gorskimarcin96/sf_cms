<?php

declare(strict_types=1);

namespace App\Factory;

use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class ContactMailer
{
    public function __construct(private string $appEmail, private Environment $twig)
    {
    }

    /**
     * @throws RuntimeError|SyntaxError|LoaderError
     */
    public function build(string $email, string $message): Email
    {
        return (new Email())
            ->from($email)
            ->to($this->appEmail)
            ->subject('Formularz kontaktowy mgorski.dev')
            ->html($this->twig->render('component/email.html.twig', ['email' => $email, 'description' => $message]));
    }
}
