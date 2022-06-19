<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Tools\EasyAdmin\Field\TranslationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn): Article
    {
        return (new Article())->setUser($this->getUser());
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')->onlyOnIndex();
        yield TranslationField::new('translations', 'Translations', [
            'title' => [
                'field_type' => TextType::class,
                'label'      => 'Title',
            ],
            'description' => [
                'field_type' => TextareaType::class,
                'label'      => 'Description',
            ],
        ])->hideOnIndex();
        yield ImageField::new('fileFn')->setUploadDir(Article::getUploadDir())->setBasePath(Article::getBasePath())->setRequired(false);
        yield AssociationField::new('user')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
