<?php

declare(strict_types=1);

namespace App\Tools\EasyAdmin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

final class PasswordIndexField implements FieldInterface
{
    use FieldTrait;

    /** @param string[][] $fieldsConfig */
    public static function new(string $propertyName, ?string $label = null, array $fieldsConfig = []): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(HiddenType::class)
            ->setTemplatePath('easyadmin/fields/password.html.twig');
    }
}
