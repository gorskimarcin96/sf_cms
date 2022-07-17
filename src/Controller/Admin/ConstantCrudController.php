<?php

namespace App\Controller\Admin;

use App\Entity\Constant;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConstantCrudController extends AbstractCrudController
{
    private string $dropboxClientId;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->dropboxClientId = $parameterBag->get('dropbox.key');
    }

    public static function getEntityFqcn(): string
    {
        return Constant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title')->onlyOnIndex(),
            TextField::new('description'),
        ];
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $query = $this->container->get(EntityRepository::class)
            ->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        return $query->andWhere('entity.title IN (:constants)')
            ->setParameter('constants', [Constant::DROPBOX_AUTHORIZATION_CODE, Constant::DROPBOX_ACCESS_TOKEN]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $dropboxCode = Action::new('dropboxCode', 'Dropbox code')
            ->linkToUrl(function () {
                return 'https://www.dropbox.com/oauth2/authorize?client_id='.$this->dropboxClientId.'&response_type=code&token_access_type=offline';
            })->displayIf(function (Constant $constant) {
                return $constant->getTitle() === Constant::DROPBOX_AUTHORIZATION_CODE;
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $dropboxCode)
            ->add(Crud::PAGE_EDIT, $dropboxCode);
    }
}
