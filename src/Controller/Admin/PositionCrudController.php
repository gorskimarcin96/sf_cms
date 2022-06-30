<?php

namespace App\Controller\Admin;

use App\Entity\Position;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PositionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Position::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id');
        yield TextField::new('image')->setTemplatePath('easyadmin/fields/image_base64.html.twig');
        yield TextField::new('title');
        yield TextField::new('first_section');
        yield TextField::new('second_section')->setTemplatePath('easyadmin/fields/raw.html.twig');
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
