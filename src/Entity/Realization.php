<?php

namespace App\Entity;

use App\Entity\Interface\TranslatableInterface;
use App\Entity\Interface\TranslationInterface;
use App\Entity\Traits\FileUploadTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimeStampableTrait;
use App\Entity\Traits\TranslatableTrait;
use App\Enum\LocaleEnum;
use App\Repository\RealizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealizationRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Realization implements TranslatableInterface
{
    use IdTrait;
    use TimeStampableTrait;
    use FileUploadTrait;
    use TranslatableTrait;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /** @var Collection<int, RealizationTranslation|TranslationInterface> */
    #[ORM\OneToMany(targetEntity: RealizationTranslation::class, mappedBy: 'translatable', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
        $this->translations = new ArrayCollection();
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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

    public function translate(string $locale): RealizationTranslation|TranslationInterface
    {
        return $this->translations
            ->filter(fn (TranslationInterface $translation): bool => $translation->getLocale() === $locale)
            ->first() ?: throw new \LogicException('Translation not exists.');
    }
}
