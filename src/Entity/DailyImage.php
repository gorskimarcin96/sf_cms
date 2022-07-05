<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\DailyImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyImageRepository::class)]
class DailyImage
{
    use TimeStampableTrait;

    #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column(type: "integer")]
     private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
     private string $name;

    #[ORM\Column(type: "text")]
     private string $image;

    public function getId(): int
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

    public function getImage(): string
    {
        return base64_decode($this->image);
    }

    public function setImage(string $image): self
    {
        $this->image = base64_encode(file_get_contents($image));

        return $this;
    }
}
