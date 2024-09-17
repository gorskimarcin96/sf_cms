<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Interface\TranslatableInterface;
use App\Entity\Interface\TranslationInterface as Locale;
use Doctrine\ORM\Mapping as ORM;

trait TranslateTrait
{
    #[ORM\Column(type: 'string', length: 2)]
    private string $locale = Locale::ENGLISH;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTranslatable(): TranslatableInterface
    {
        return $this->translatable;
    }

    public function setTranslatable(?TranslatableInterface $translatable): static
    {
        $this->translatable = $translatable;

        return $this;
    }
}
