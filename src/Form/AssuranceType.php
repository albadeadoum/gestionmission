<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Assurance;
use App\Entity\Vehicule;
use App\Entity\Moto;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class AssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numero', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'Numero Assurance',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('debut', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label' => 'Date de début',
                'label_attr' => ['class' => 'form-label mt-2']
            ])
            ->add('fin', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label' => 'Date de fin',
                'label_attr' => ['class' => 'form-label mt-2']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Véhicule' => 'vehicule',
                    'Moto' => 'moto',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                    ],
                    'label' => 'Type Assurance',
                'mapped' => false,
                'placeholder' => 'Choisissez un type',
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                
                'required' => false,
                'placeholder' => 'Sélectionnez un véhicule',
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                    ],
                    'label' => 'Selecttion du vehicule',
                
            ])
            ->add('moto', EntityType::class, [
                'class' => Moto::class,
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                    ],
                    'label' => 'Selection de la Moto',
                'required' => false,
                'placeholder' => 'Sélectionnez une moto',
            ]);

        
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}



