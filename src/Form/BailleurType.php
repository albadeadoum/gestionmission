<?php

namespace App\Form;

use App\Entity\Bailleur;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class BailleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
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
            ->add('taux_ag', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Taux jour journalier auxillaire',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                
                'constraints' => [
                    new Assert\PositiveOrZero(), // accepte zéro et positif
                ]
            ])
            ->add('taux_ox', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Taux jour journalier oxillier',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                
                'constraints' => [
                    new Assert\PositiveOrZero(), // accepte zéro et positif
                ]
            ])
            /*->add('mission', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'id',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bailleur::class,
        ]);
    }
}
