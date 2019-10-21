<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('lastname',TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('email',EmailType::class, [
                'label' => 'Votre mail :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('subject',TextType::class, [
                'label' => 'Sujet :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('message',TextareaType::class, [
                'label' => 'Message :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}