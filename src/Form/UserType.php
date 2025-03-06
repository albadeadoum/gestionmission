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
            ->add('roles' , ChoiceType:: class , [

                'mapped' => true,
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form',
                ],
                'label' => 'Roles ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],

                'attr' => [
                    'class' => 'btn-group btn-group-toggle',
                    'data-toggle' => 'buttons'
                ],

                'multiple' => true,
            'expanded' => true, // render check-boxes
            'choices' => [
                'admin' => 'ROLE_ADMIN',
                'user' => 'ROLE_USER',
                'Chauffeur' => 'ROLE_CHAUFFEUR',
            ],

                'choice_attr' => [
                    'class' => 'btn btn-secondary' // Ajoutez la classe Bootstrap souhaitée ici
                ],
            ]) 
            ->add('Status' , ChoiceType:: class , [
                'attr' => [
                    'class' => 'form',
                ],
                'label' => 'Status ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choices' => [
                    'ACTIF'=> 'ACTIF' ,
                    'INACTIF'=> 'INACTIF'
                ]
            ])
            ->add('mission', EntityType::class, ['class' => Evenement::class,
            'placeholder' => 'Choisissez la mission',
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
