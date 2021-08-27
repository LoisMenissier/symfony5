<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur'
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Magistrat' => 'ROLE_MAGISTRAT',
                    'Expert' => 'ROLE_EXPERT',
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('email', TextType::class, [
                'label' => 'Adresse email',
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'label' => 'Activé',
                'data' => true
            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(NEW CallbackTransformer(
                function($rolesArray){
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function($rolesString){
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
