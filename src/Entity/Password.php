<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\PasswordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;

#[ORM\Entity(repositoryClass: PasswordRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Password
{
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $website;

    #[ORM\Column(type: "string", length: 100)]
    private string $login;

    #[ORM\Column(type: "string", length: 500)]
    private string $password;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 20)]
    private string $salt;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: "boolean")]
    private bool $isPublic = false;

    #[ORM\Column(type: "boolean")]
    private bool $usePin;

    #[ORM\Column(type: "smallint", nullable: true)]
    private string $daysToPasswordChange;

    private ?int $pin = null;

    public function __construct()
    {
        $this->salt = ByteString::fromRandom(20);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPin(): ?int
    {
        return null;
    }

    public function setPin(int $pin): self
    {
        $this->pin = $pin;

        return $this;
    }


    #[ORM\PrePersist()]
    #[ORM\PreUpdate()]
    public function saltPassword(): void
    {
        $this->usePin = (bool)strlen($this->pin);
        $this->password = $this->getUsePin() ? ($this->pin.$this->password.$this->salt) : $this->password;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getDaysToPasswordChange(): string
    {
        return $this->daysToPasswordChange;
    }

    public function setDaysToPasswordChange(string $daysToPasswordChange): self
    {
        $this->daysToPasswordChange = $daysToPasswordChange;

        return $this;
    }

    public function getUsePin(): bool
    {
        return $this->usePin;
    }
}
