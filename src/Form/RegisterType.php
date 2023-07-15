<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,
            [
                'label' => 'Votre prénom',
                'constraints' =>
                    [
                    new Length(
                        [
                            'min' => 2,
                            'max' => 30,
                        ]),
                    new NotBlank()
                    ],
                'attr' => ['placeholder' => 'Saisissez votre prénom' ]
            ])
            ->add('lastname', TextType::class,
            [
                'label' => 'Votre nom',
                'constraints' =>
                    [
                        new Length(
                            [
                                'min' => 2,
                                'max' => 30,
                            ]),
                        new NotBlank()
                    ],
                'attr' => ['placeholder' => 'Saisissez votre nom' ]
            ])
            ->add('email', EmailType::class,
                [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Saisissez votre email' ]
            ])
            ->add('password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'les mots de passe doit être identitique',
                    'label' => 'Mot de passe',
                    'required' => true,
                    'first_options' =>
                        [
                            'label' => 'Votre mot de passe',
                            'attr' =>
                                [
                                    'placeholder' => 'Saisissez votre mot de passe'
                                ]
                        ],
                    'second_options' =>
                        [
                            'label' => 'Confirmez votre mot de passe',
                            'attr' =>
                                [
                                    'placeholder' => 'Confirmez votre mot de passe'
                                ]
                        ],

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
