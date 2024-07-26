<?php

namespace App\Entity\Interface;

interface TranslationInterface
{
    const POLISH = 'pl';
    const ENGLISH = 'en';

    public function __construct(?int $id = null, string $locale = self::ENGLISH);

    public function getLocale(): string;

    public function setLocale(string $locale): static;

    public function getTranslatable(): TranslatableInterface;

    public function setTranslatable(TranslatableInterface $translatable): static;
}
