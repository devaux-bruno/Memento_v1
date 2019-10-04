<?php


namespace App\Form;


use App\Entity\Languages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguagesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('langProgram',TextType::class, [
                'label' => 'Nouveau Languages',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('langPicture', FileType::class, [
                'label' => 'Ajouter un logo :',
                'attr' => [
                    'class' => "form-control"
                ],
                'data_class' => null,
                'required'=>true,
            ])
            ->add('langOrder', IntegerType ::class, [
                'label' => 'Numéro d\'ordre :',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Valider',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Languages::class,
        ]);
    }
}