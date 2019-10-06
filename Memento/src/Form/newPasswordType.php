<?php



namespace App\Form;

use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class newPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('userPassword',PasswordType::class, [
                'label' => 'Ancien mot de passe',
                'attr' => [
                    'class' => "form-control"
                ],
                'mapped' => false,

            ])
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmer nouveau mot de passe'),
                'options' => ['attr' => ['class' => "form-control"]],
                'required' => true,
                'mapped' => false,
            ))
            ->add('save', SubmitType::class ,[
                'label' => 'Changer mot de passe',
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
