<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Validator\ChauffeurDisponibilite;
use App\Validator\VehiculeDisponibilite;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EveneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'label' => 'Objet',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])
        ->add('debut', TypeDateType::class , array(
            'required' => true,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control input-inline datetimepicker',
                'data-provide' => 'datetimepicker',
                'html5' => false,
            ],
            'label' => 'Date début'
            ))
        ->add('fin', TypeDateType::class , array(
            'required' => true,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control input-inline datetimepicker',
                'data-provide' => 'datetimepicker',
                'html5' => false,
            ],
            'label' => 'Date fin'
            ))
        ->add('description', TextareaType::class, [
            'attr' => [
                'class' => 'form-control',
                'rows' => 3
            ],
            'label' => 'Description',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 500]),
                new Assert\NotBlank()
            ]
        ])
        /*->add('Dotation', ChoiceType::class, [
            'placeholder' => 'Choisissez un statut',
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
            ],
            'label' => 'Dotation',
            'label_attr' => [
                'class' => 'form-label mt-2'
            ],
            'choices' => [
                'Espèces' => 'Espèces',
                'Carte' => 'Carte',
            ],
        ])
        ->add('Montant', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Montant',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\Length(['min' => 0, 'max' => 15]),
            ]
        ])
        ->add('background_color', ColorType::class , [ 'label' => 'Arrière plan........'])
        ->add('border_color', ColorType::class , [ 'label' => 'Bordure couleur..'])
        ->add('text_color', ColorType::class , [ 'label' => 'Text couleur........', ])
            ->add('Vehicule')
            ->add('Chauffeur')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
