<?php

namespace App\Controller\Admin;

use App\Entity\Anniversary;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnniversaryCrudController extends AbstractCrudController
{
    use ProcessUploadedFiles;

    public function __construct(private iterable $connectorServices)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Anniversary::class;
    }

    public function createEntity(string $entityFqcn): Anniversary
    {
        return (new Anniversary())->setUser($this->getUser())->setDate(new DateTime());
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            DateField::new('date'),
            TextField::new('name'),
            ImageField::new('fileFn')
                ->setUploadDir(Anniversary::getUploadDir())
                ->setBasePath(Anniversary::getBasePath())
                ->setCustomOption('connector', Anniversary::getConnector())
                ->onlyOnForms(),
            ImageField::new('base64')
                ->setTemplatePath('easyadmin/fields/image_base64.html.twig')
                ->setCssClass('w-200px')
                ->onlyOnIndex()
        ];
    }
}
