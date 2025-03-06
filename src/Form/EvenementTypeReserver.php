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
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;


class EvenementTypeReserver extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Vehicule', EntityType::class, ['class' => Vehicule::class,
            'placeholder' => 'Choisissez un Vehicule',
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
                ],
                'label' => 'Vehicule libre',
                'constraints' => [
                    new VehiculeDisponibilite(),
                ],
            ])
            ->add('Chauffeur' , EntityType::class, ['class' => Chauffeur::class,
            'placeholder' => 'Choisissez un Chauffeur',
            'attr' => [
                'class' => 'form-control',
                'data-live-search' => 'true',
                'label' => 'Chauffeur libre',
                ],
                'constraints' => [
                    new ChauffeurDisponibilite(),
                ],
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Objet de la mission',
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
                'label' => 'date début'
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
            ->add('background_color', ColorType::class , [ 'label' => 'Arrière plan........' , 'data' => '#3FF11C'])
            ->add('border_color', ColorType::class , [ 'label' => 'Bordure couleur..', 'data' => '#000000'])
            ->add('text_color', ColorType::class , [ 'label' => 'Text couleur........', ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
