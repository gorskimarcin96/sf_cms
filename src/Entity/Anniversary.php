<?php

namespace App\Entity;

use App\Entity\Traits\FileUploadTrait;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\AnniversaryRepository;
use App\Tools\Integration\Dropbox\Client;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnniversaryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Anniversary implements ConnectorInterface
{
    use TimeStampableTrait;
    use FileUploadTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $date;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    private string $base64;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public static function getConnector(): string
    {
        return Client::class;
    }

    public function getConnectorPath(): string
    {
        return $this::getBasePath().'/'.$this->getFileFn();
    }

    public function setBase64(string $file): void
    {
        $this->base64 = $file;
    }

    public function getBase64(): string
    {
        return $this->base64;
    }
}
