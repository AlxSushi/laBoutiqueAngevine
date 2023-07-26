<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])

            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' =>[
                    'placeholder' => 'Saisissez votre mot de passe actuel'
                ]
            ])

            ->add('new_password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'les mots de passe doit être identitique',
                    'label' => 'Mon nouveau mot de passe',
                    'mapped'=> false,
                    'required' => true,
                    'first_options' =>
                        [
                            'label' => 'Votre nouveau mot de passe',
                            'attr' =>
                                [
                                    'placeholder' => 'Saisissez votre nouveau mot de passe'
                                ]
                        ],
                    'second_options' =>
                        [
                            'label' => 'Confirmez votre nouveau mot de passe',
                            'attr' =>
                                [
                                    'placeholder' => 'Confirmez votre nouveau mot de passe'
                                ]
                        ],
                ])

            ->add('submit', SubmitType::class,
                [
                    'label' => 'Mettre à jour'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
