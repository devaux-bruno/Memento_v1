<?php


namespace App\Form;


use App\Entity\Articles;
use App\Entity\Languages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('articleTitle',TextType::class, [
                'label' => 'Titre de l\'articles',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('articlePicture', FileType::class, [
                'label' => 'Votre Photo de profil :',
                'attr' => [
                    'class' => "form-control"
                ],
                'data_class' => null,
                'required'=>false,
            ])
            ->add('articleDescription', TextareaType::class,[
                'label' => 'Mot clés pour la recherche:',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>false,
            ])
            ->add('articleText', TextareaType::class,[
                'label' => 'Votre article:',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('articleLanguage', EntityType::class, [
                // looks for choices from this entity
                'class' => Languages::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'langProgram',
                'label' => 'Language de programmation',
                'attr' => [
                    'class' => "form-control"
                ],
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Ajouter article',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}