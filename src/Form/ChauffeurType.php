<?php

namespace App\Form;

use App\Entity\Chauffeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;


class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('dateNaiss', TypeDateType::class , array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                'label' => 'Date de naissance'
                ))
                ->add('adress', TextType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => '2',
                        'maxlength' => '500'
                    ],
                    'label' => 'Adresse',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 2, 'max' => 255]),
                        new Assert\NotBlank()
                    ]
                ])
                
            ->add('Numero', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numero de Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\Length(['min' => 8, 'max' => 15]),
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'placeholder' => 'Choisissez un statut',
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                ],
                'label' => 'Statut',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'choices' => [
                    'Titulaire' => 'Titulaire',
                    'Contractuel' => 'Contractuel',
                    'Bénévole' => 'Bénévole',
                ],
            ])
            ->add('matricule', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'matricule',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chauffeur::class,
        ]);
    }
}
