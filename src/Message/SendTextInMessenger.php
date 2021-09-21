<?php

namespace App\Message;

final class SendTextInMessenger
{
    private array $text;

    public function __construct(
        private string $login,
        private string $password,
        private string $userUrl,
        string|array   $text
    ) {
        $this->text = is_string($text) ? [$text] : $text;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserUrl(): string
    {
        return $this->userUrl;
    }

    /** string[] */
    public function getText(): array
    {
        return $this->text;
    }
}
