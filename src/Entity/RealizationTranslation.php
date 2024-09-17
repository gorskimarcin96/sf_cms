<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\TranslatableInterface;
use App\Entity\Interface\TranslationInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TranslateTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['translatable_id', 'locale'])]
class RealizationTranslation implements TranslationInterface
{
    use IdTrait;
    use TranslateTrait;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Realization::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'translatable_id', nullable: false)]
    private Realization|TranslatableInterface $translatable;

    public function __construct(?int $id = null, string $locale = TranslationInterface::ENGLISH)
    {
        $this->id = $id;
        $this->locale = $locale;
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
