<?php

namespace App\Ovh\Model;

use DateTime;
use DateTimeInterface;

class Service
{
    public function __construct(
        private int $id,
        private string $name,
        private string $displayName,
        private DateTimeInterface $createdAt,
        private DateTimeInterface $expiredDate,
        private DateTimeInterface $nexBillingDate
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getExpiredDate(): DateTimeInterface
    {
        return $this->expiredDate;
    }

    public function getNexBillingDate(): DateTimeInterface
    {
        return $this->nexBillingDate;
    }

    public function daysToPaid(): int
    {
        $now = new DateTime();

        return $now->diff(clone $this->nexBillingDate)->format('%a');
    }
}