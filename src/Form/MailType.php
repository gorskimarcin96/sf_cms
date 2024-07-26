<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $class = 'form-control mb-4 border border-light bg-dark text-light';

        $builder
            ->add('email', EmailType::class, ['label' => 'E-mail', 'attr' => ['class' => $class]])
            ->add('message', TextareaType::class, ['label' => 'Message', 'attr' => ['class' => $class]])
            ->add('number', NumberType::class, ['label' => 'What is the result for 2 + 3?', 'attr' => ['class' => $class]])
            ->add('submit', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'btn btn-success ml-auto d-block']]);
    }
}
