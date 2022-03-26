<?php

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationField;
use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function createEntity(string $entityFqcn): Offer
    {
        return (new Offer())->setUser($this->getUser());
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')->onlyOnIndex();
        yield TranslationField::new('translations', 'Translations', [
            'title' => [
                'field_type' => TextType::class,
                'label'      => 'Title',
            ]
        ])->hideOnIndex();
        yield AssociationField::new('user')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
