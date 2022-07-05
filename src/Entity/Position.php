<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionRepository::class)]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $title;

    #[ORM\Column(type: "text")]
    private ?string $image;

    #[ORM\Column(type: "text")]
    private ?string $firstSection;

    #[ORM\Column(type: "text")]
    private ?string $secondSection;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        if (!str_contains($image, 'http:')) {
            $image = 'http:' . $image;
        }

        $this->image = base64_encode(file_get_contents($image));

        return $this;
    }

    public function getFirstSection(): ?string
    {
        return $this->firstSection;
    }

    public function setFirstSection(string $firstSection): self
    {
        $this->firstSection = $firstSection;

        return $this;
    }

    public function getSecondSection(): ?string
    {
        return $this->secondSection;
    }

    public function setSecondSection(string $secondSection): self
    {
        $this->secondSection = $secondSection;

        return $this;
    }
}
