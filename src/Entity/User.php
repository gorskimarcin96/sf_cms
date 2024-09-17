<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    use IdTrait;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
