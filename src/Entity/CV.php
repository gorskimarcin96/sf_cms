<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Enum\CVEnum;
use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    use IdTrait;

    #[ORM\Column(unique: true, enumType: CVEnum::class)]
    private CVEnum $type;

    #[ORM\Column(type: 'text')]
    private string $description = '';

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function getType(): CVEnum
    {
        return $this->type;
    }

    public function setType(CVEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
