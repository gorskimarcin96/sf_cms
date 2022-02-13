<?php

namespace App\Form;

use App\Entity\TodoList;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoListType extends AbstractType
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr'  => ['class' => 'form-control mb-2', 'placeholder' => 'List name'],
            ])
            ->add('userAccess', EntityType::class, [
                'label'    => false,
                'class'    => User::class,
                'multiple' => true,
                'required' => false,
                'attr'     => ['class' => 'form-control mb-2', 'placeholder' => 'List name'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr'  => ['class' => 'btn btn-primary ms-auto d-block'],
            ])
            ->setAction($this->adminUrlGenerator->setRoute('easyadmin_todolist_create_list')->generateUrl());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TodoList::class,
        ]);
    }
}
