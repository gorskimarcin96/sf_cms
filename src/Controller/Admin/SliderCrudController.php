<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use App\Tools\EasyAdmin\Field\TranslationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    public function createEntity(string $entityFqcn): Slider
    {
        return (new Slider())->setUser($this->getUser());
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
        yield ImageField::new('fileFn')->setUploadDir(Slider::getUploadDir())->setBasePath(Slider::getBasePath())->setRequired(false);
        yield AssociationField::new('user')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
