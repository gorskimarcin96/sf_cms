<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface TranslationInterface
{
    public const POLISH = 'pl';

    public const ENGLISH = 'en';

    public function __construct(?int $id = null, string $locale = self::ENGLISH);

    public function getLocale(): string;

    public function setLocale(string $locale): static;

    public function getTranslatable(): TranslatableInterface;

    public function setTranslatable(?TranslatableInterface $translatable): static;
}
