<?php

namespace App\Form;

use App\Entity\Piece;
use App\Entity\Vehicule;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Vehicule' , EntityType::class, ['class' => Vehicule::class,
            'placeholder' => 'Choisissez le véhicule',
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
                ],
            ])
            ->add('Nom', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 1000]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Date' , TypeDateType::class , array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
                ],
                'label' => 'date fin'
                ))
            ->add('Quantitite' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Quantitite',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    
                ]
            ])
            ->add('cout' , IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'coût',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    
                ]
            ])
            ->add('Observation' , TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'label' => 'Observation',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 1000]),
                    new Assert\NotBlank()
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
