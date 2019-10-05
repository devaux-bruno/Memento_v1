<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('userPseudo',TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userEmail', EmailType::class, [
                'label' => 'Adresse mail : ',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userFirstname',TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userLastname',TextType::class, [
                'label' => 'Nom de famille',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userJob',TextType::class, [
                'label' => 'Profession',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userBirthday', BirthdayType::class, [
                'label' => 'Votre date de naissance :',
                'empty_data' => '',
                'widget' => 'choice',
                'years' => range(1945,2019),
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                //'attr' => ['class' => 'js-datepicker','form-control'],
                //'data_class' => null,
                //'required' => false,
            ])
            ->add('userCity',TextType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('userPicture', FileType::class, [
                'label' => 'Votre Photo de profil :',
                'attr' => [
                    'class' => "form-control"
                ],
                'data_class' => null,
                'required'=>false,
            ])
            ->add('userDescription', TextareaType::class,[
                'label' => 'Votre description ou commentaire',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>false,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Modifier',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

}