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
class ArticleTranslation implements TranslationInterface
{
    use IdTrait;
    use TranslateTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private Article|TranslatableInterface $translatable;

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
