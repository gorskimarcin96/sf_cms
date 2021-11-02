<?php

namespace App\Message;

final class Mailer
{
    public function __construct(private string $from, private array $to, private string $type)
    {
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
