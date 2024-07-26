<?php

namespace App\Entity\Traits;

use App\Entity\Interface\TranslationInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait TranslatableTrait
{
    /** @var Collection<int, TranslationInterface> */
    #[ORM\OneToMany(targetEntity: TranslationInterface::class, mappedBy: 'translatable', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function addTranslation(TranslationInterface $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setTranslatable($this);
        }

        return $this;
    }

    public function removeTranslation(TranslationInterface $translation): static
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);

            if ($translation->getTranslatable() === $this) {
                $translation->setTranslatable(null);
            }
        }

        return $this;
    }

    /** @return Collection<int,TranslationInterface> */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }
}
