<?php

namespace App\Entity;

use App\Repository\CounterRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CounterRepository::class)]
class Counter
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $sessionId;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $ip;

    #[ORM\Column(type: "integer")]
    private ?int $refresh;

    #[ORM\Column(type: "integer")]
    private ?int $entry;

    #[ORM\Column(type: "date")]
    private ?DateTimeInterface $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getRefresh(): ?int
    {
        return $this->refresh;
    }

    public function setRefresh(int $refresh): self
    {
        $this->refresh = $refresh;

        return $this;
    }

    public function getEntry(): ?int
    {
        return $this->entry;
    }

    public function setEntry(int $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
