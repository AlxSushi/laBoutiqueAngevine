<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,
            [
                'label' => 'Votre prénom',
                'attr' => ['placeholder' => 'Saisissez votre prénom' ]
            ])
            ->add('lastname', TextType::class,
            [
                    'label' => 'Votre nom',
                    'attr' => ['placeholder' => 'Saisissez votre nom' ]
            ])
            ->add('email', EmailType::class,
                [
            'label' => 'Email',
                'attr' => ['placeholder' => 'Saisissez votre email' ]
            ])
            ->add('password', PasswordType::class,
                [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Saisissez votre mot de passe' ]
            ])
            ->add('password_confirm', PasswordType::class,
                [
                    'label' => 'Confirmation du mot de passe',
                    'mapped' => false,
                    'attr' => ['placeholder' => 'Saisissez votre mot de passe' ]
                ])

            ->add('submit', SubmitType::class,
            [
                'label' => 'S\'inscrire'
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