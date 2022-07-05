<?php

namespace App\Entity;

use App\DBAL\Types\PositionType;
use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

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

    #[ORM\Column(type: PositionType::class, length: 2)]
    #[DoctrineAssert\EnumType(entity: PositionType::class)]
    private string $positionType;

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
            $image = 'http:'.$image;
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

    public function getPositionType(): string
    {
        return $this->positionType;
    }

    public function setPositionType(string $positionType): self
    {
        PositionType::assertValidChoice($positionType);
        $this->positionType = $positionType;

        return $this;
    }
}
