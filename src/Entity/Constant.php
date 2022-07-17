<?php

namespace App\Entity;

use App\Repository\ConstantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConstantRepository::class)]
class Constant
{
    public const CV = 'CV';
    public const CV_DRAFT = 'CV_DRAFT';
    public const DROPBOX_AUTHORIZATION_CODE = 'DROPBOX_AUTHORIZATION_CODE';
    public const DROPBOX_ACCESS_TOKEN = 'DROPBOX_ACCESS_TOKEN';
    public const DROPBOX_REFRESH_TOKEN = 'DROPBOX_REFRESH_TOKEN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private ?string $title;

    #[ORM\Column(type: "text")]
    private ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
