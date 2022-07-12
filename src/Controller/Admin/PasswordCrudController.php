<?php

namespace App\Controller\Admin;

use App\Entity\Password;
use App\Tools\EasyAdmin\Field\PasswordIndexField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Password::class;
    }

    public function createEntity(string $entityFqcn): Password
    {
        return (new Password())->setUser($this->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeCrudActionEvent::class => ['setDefaultEditData'],
        ];
    }

    public function setDefaultEditData(BeforeCrudActionEvent $event): void
    {
        $entity = $event->getAdminContext()?->getEntity()->getInstance();

        if (!($entity instanceof Password)) {
            return;
        }

        $entity->setPassword('');
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user')->hideOnForm();
        yield TextField::new('website');
        yield TextField::new('login');
        yield TextField::new('password')->onlyOnForms();
        yield PasswordIndexField::new('password')->onlyOnIndex();
        yield NumberField::new('pin')->setFormType(PasswordType::class)->onlyOnForms();
        yield TextField::new('description');
        yield NumberField::new('daysToPasswordChange');
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
        yield BooleanField::new('isPublic')->onlyOnForms();
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $query = $this->container->get(EntityRepository::class)
            ->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        return $query->andWhere('entity.user = :user OR entity.isPublic = true')
            ->setParameter('user', $this->getUser());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPaginatorPageSize(1000)
            ->overrideTemplate('crud/index', 'easyadmin/password_list.html.twig')
            ->overrideTemplate('layout', 'easyadmin/layout.html.twig');
    }
}
