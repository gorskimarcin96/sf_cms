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
    public const ATTR_CLASS = 'form-control mb-4 border border-light bg-dark text-light';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'E-mail', 'attr' => ['class' => static::ATTR_CLASS]])
            ->add('message', TextareaType::class, ['label' => 'Message', 'attr' => ['class' => static::ATTR_CLASS]])
            ->add('number', NumberType::class, ['label' => 'What is the result for 2 + 3?', 'attr' => ['class' => static::ATTR_CLASS]])
            ->add('submit', SubmitType::class, ['label' => 'Send', 'attr' => ['class' => 'btn btn-success ml-auto d-block']]);
    }
}
