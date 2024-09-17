<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\TranslatableInterface;
use App\Entity\Interface\TranslationInterface;
use App\Entity\Traits\FileUploadTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimeStampableTrait;
use App\Entity\Traits\TranslatableTrait;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Article implements TranslatableInterface
{
    use IdTrait;
    use TimeStampableTrait;
    use FileUploadTrait;
    use TranslatableTrait;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /** @var Collection<int, ArticleTranslation|TranslationInterface> */
    #[ORM\OneToMany(targetEntity: ArticleTranslation::class, mappedBy: 'translatable', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
        $this->translations = new ArrayCollection();
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

    public function translate(string $locale): TranslationInterface|ArticleTranslation
    {
        return $this->translations
            ->filter(fn (TranslationInterface $translation): bool => $translation->getLocale() === $locale)
            ->first() ?: throw new \LogicException('Translation not exists.');
    }
}
