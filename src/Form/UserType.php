<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email' , EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
            ->add('password' , RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label  mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('Nom' , TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Prenom' , TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'mapped' => true,
                'multiple' => true,      // plusieurs rôles possibles
                'expanded' => true,      // affichage sous forme de cases à cocher
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur'    => 'ROLE_USER',
                    'Chauffeur'      => 'ROLE_CHAUFFEUR',
                ],
                'choice_attr' => function ($choice, $key, $value) {
                    return [
                        'class' => 'btn-check', // classe Bootstrap pour custom radio/checkbox
                        'autocomplete' => 'off',
                    ];
                },
                'label_attr' => [
                    'class' => 'form-label mt-3 d-block'
                ],
                'attr' => [
                    'class' => 'btn-group d-flex', // groupe de boutons
                    'data-toggle' => 'buttons'
                ],
            ])

            ->add('Status' , ChoiceType:: class , [
                'attr' => [
                    'class' => 'form',
                ],
                 'expanded' => true,   // affichage en boutons radio
                 'attr' => ['class' => 'form-check'],
                'label' => 'Status ',
                'label_attr' => [
                    'class' => 'form-label fw-bold mt-3'
                ],
                'choices' => [
                    'ACTIF'=> 'ACTIF' ,
                    'INACTIF'=> 'INACTIF'
                ]
            ])
            ->add('mission', EntityType::class, ['class' => Evenement::class,
            'placeholder' => 'Choisissez la mission',
            'required' => false, 
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
                ],
                'label' => 'Mission Affecter',
                
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
