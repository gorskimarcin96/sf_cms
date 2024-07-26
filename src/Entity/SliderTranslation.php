<?php

namespace App\Entity;

use App\Entity\Interface\TranslatableInterface;
use App\Entity\Interface\TranslationInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TranslateTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['translatable_id', 'locale'])]
class SliderTranslation implements TranslationInterface
{
    use IdTrait;
    use TranslateTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Slider::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private Slider|TranslatableInterface $translatable;

    public function __construct(?int $id = null, string $locale = TranslationInterface::ENGLISH)
    {
        $this->id = $id;
        $this->locale = $locale;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
