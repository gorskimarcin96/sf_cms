<?php

namespace App\Controller\Admin;

use App\Entity\DogJoke;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class DogJokeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DogJoke::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id');
        yield UrlField::new('url');
        yield TextField::new('image')->setTemplatePath('easyadmin/fields/image_base64.html.twig');
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPaginatorPageSize(100);
    }
}
