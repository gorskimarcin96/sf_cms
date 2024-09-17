<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use Doctrine\Common\Collections\Collection;

interface TranslatableInterface
{
    public function addTranslation(TranslationInterface $translation): static;

    public function translate(string $locale): TranslationInterface;

    /** @return Collection<int,TranslationInterface> */
    public function getTranslations(): Collection;
}
