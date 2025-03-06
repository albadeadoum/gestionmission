<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VehiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Marque'  , TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'Marque Du véhicule',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 0, 'max' => 255]),
                   
                ]
            ])
            ->add('NBChassis' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numero Chassis',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                ]
            ])
            ->add('NBMoteur' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numero Moteur',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    
                ]
            ])
            ->add('Puissace', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Puissance en Chevaux',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Etat', ChoiceType::class, [
                'placeholder' => 'Choisissez un état',
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                ],
                'label' => 'État',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'choices' => [
                    'Bon' => 'Bon',
                    'Mauvais' => 'Mauvais',
                ],
            ])
            
            ->add('Compteur' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Compteur',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    
                ]
            ])
            ->add('pneus' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Pneus',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image du Véhicule',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false, // facultatif, à modifier selon vos besoins
                'attr' => [
                    'accept' => 'image/*' // spécifie que seules les images sont autorisées
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
