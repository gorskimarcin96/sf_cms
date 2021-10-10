<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Message\SaveLog;
use App\Message\SendTextInMessenger;
use App\Utils\Encryption\EncryptionManager;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class TaskCrudController extends AbstractCrudController
{
    public function __construct(private EncryptionManager $encryptionManager)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function createEntity(string $entityFqcn): Task
    {
        return (new Task())
            ->setUser($this->getUser())
            ->setExecutedAt(new DateTime())
            ->setEncryptionManager($this->encryptionManager);
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('class')->setChoices([
            SaveLog::class             => SaveLog::class,
            SendTextInMessenger::class => SendTextInMessenger::class,
        ])->allowMultipleChoices(false);
        yield CodeEditorField::new('arguments');
        yield DateTimeField::new('executedAt');
        yield BooleanField::new('isAdded')->renderAsSwitch(false)->hideOnForm();
        yield BooleanField::new('hasError')->renderAsSwitch(false)->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', '%entity_label_plural% ' . (new DateTime())->format('Y-m-d H:i:s'));
    }
}
