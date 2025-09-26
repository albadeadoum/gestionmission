<?php

namespace App\Form;

use App\Entity\Bailleur;
use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '500'
                ],
                'label' => 'Objet de la mission',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('bailleur', EntityType::class, ['class' => Bailleur::class,
            'placeholder' => 'Choisissez le bailleur de financement',
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
                ],
                'label' => 'Bailleur de financement',
                
                'label_attr' => [
                    'class' => 'form-label fw-bold mt-3'
                ],
            ])
            ->add('type' , ChoiceType::class, [
                'placeholder' => 'Type de la mission',
                'attr' => [
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                ],
                'label' => 'Choisissez LE Type de la mission',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'choices' => [
                    'NATIONAL' => 'NATIONAL',
                    'INTERNATIONAL' => 'INTERNATIONAL',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
