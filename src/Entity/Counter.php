<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\CounterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CounterRepository::class)]
class Counter
{
    use IdTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $sessionId = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ip = null;

    #[ORM\Column(type: 'string', length: 1000)]
    private ?string $url = null;

    #[ORM\Column(type: 'integer')]
    private ?int $refresh = null;

    #[ORM\Column(type: 'integer')]
    private ?int $entry = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
