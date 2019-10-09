<?php


namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('commentText',TextareaType::Class, [
                'label' => 'Votre commentaire:',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Poster le commentaire',
                'attr' => [
                    'class' => "btn btn-primary mb-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}