<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $image;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $first_section;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $second_section;

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
        return base64_decode($this->image);
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
        return $this->first_section;
    }

    public function setFirstSection(string $first_section): self
    {
        $this->first_section = $first_section;

        return $this;
    }

    public function getSecondSection(): ?string
    {
        return $this->second_section;
    }

    public function setSecondSection(string $second_section): self
    {
        $this->second_section = $second_section;

        return $this;
    }
}
