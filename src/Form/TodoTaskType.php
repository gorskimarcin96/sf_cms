<?php

namespace App\Form;

use App\Entity\TodoList;
use App\Entity\TodoTask;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoTaskType extends AbstractType
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('todoList', EntityType::class, [
                'class' => TodoList::class,
                'label' => false,
                'attr'  => ['class' => 'd-none'],
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'attr'  => ['class' => 'form-control mb-2', 'placeholder' => 'Task name'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => ['class' => 'form-control mb-2', 'placeholder' => 'Description'],
            ])
            ->add('fileFn', FileType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => ['class' => 'form-control mb-2']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr'  => ['class' => 'btn ms-auto d-block mt-2'],
            ])
            ->setAction($this->adminUrlGenerator->setRoute('easyadmin_todolist_create_task')->generateUrl());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TodoTask::class,
        ]);
    }
}
