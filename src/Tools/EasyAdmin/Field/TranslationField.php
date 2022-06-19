<?php

declare(strict_types=1);

namespace App\Tools\EasyAdmin\Field;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\DBAL\Types\LocaleType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class TranslationField implements FieldInterface
{
    use FieldTrait;

    /** @param string[][] $fieldsConfig */
    public static function new(string $propertyName, ?string $label = null, array $fieldsConfig = []): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(TranslationsType::class)
            ->setFormTypeOptions([
                'default_locale'   => '%locale%',
                'required_locales' => [LocaleType::POLISH],
                'locales'          => LocaleType::getValues(),
                'fields'           => $fieldsConfig,
            ]);
    }
}
