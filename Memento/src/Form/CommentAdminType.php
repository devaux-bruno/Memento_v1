<?php


namespace App\Form;


use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentAdminType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('commentArticle', EntityType::class, [
                // looks for choices from this entity
                'class' => Articles::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'articleTitle',
                'label' => 'Quel Article?',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'required'=>true,
            ])
            ->add('commentUser', EntityType::class, [
                // looks for choices from this entity
                'class' => Users::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'userPseudo',
                'label' => 'Quel Membre?',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'required'=>true,
            ])
            ->add('commentStatus', ChoiceType::class,[
                'label' => '',
                'choices'  => [
                    'signaled' => 'signaled',
                    'Not-publish' => 'Not-publish',
                    'published' => 'published',
                ],
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
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