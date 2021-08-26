<?php

namespace App\Controller\Admin;

use App\Entity\Realization;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class RealizationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realization::class;
    }

    public function createEntity(string $entityFqcn): Realization
    {
        return (new Realization())->setUser($this->getUser());
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield UrlField::new('url');
        yield ImageField::new('fileFn')->setUploadDir(Realization::getUploadDir())->setBasePath(Realization::getBasePath());
        yield AssociationField::new('user')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
