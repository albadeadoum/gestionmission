<?php

namespace App\Form;


use App\Entity\Evenement;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Entity\Bailleur;
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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Mission;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\CallbackTransformer;


class EvenementTypeReserver extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isFromMission = $options['from_mission'] ?? false;

        $builder
             ->add('Destination', TextType::class, [
                'attr' => ['class' => 'form-control', 'minlength' => '2', 'maxlength' => '500'],
                'label' => 'Axe-Destination',
                'constraints' => [new Assert\Length(['min' => 2, 'max' => 255]), new Assert\NotBlank()]
            ])
            
            ->add('debut', TypeDateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control input-inline datetimepicker'],
                'label' => 'Date début'
            ])
            ->add('fin', TypeDateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control input-inline datetimepicker'],
                'label' => 'Date fin'
            ])
           
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 3],
                'label' => 'Description',
                'required' => false,
                'constraints' => [new Assert\Length(['min' => 2, 'max' => 500])]
            ])
            // Dans votre buildForm()
            ->add('background_color', HiddenType::class, [
                'data' => '#3FF11C',
                'empty_data' => '#3FF11C'
            ])
            ->add('border_color', HiddenType::class, [
                'data' => '#000000', 
                'empty_data' => '#000000'
            ])
            ->add('text_color', HiddenType::class, [
                'empty_data' => '#000000' // ou la valeur par défaut souhaitée
            ])
        ;

        // ✅ Ajouter titre + bailleur uniquement si on n’est pas dans une mission
        if (!$isFromMission) {
            $builder
                ->add('titre', TextType::class, [
                    'attr' => ['class' => 'form-control', 'minlength' => '2', 'maxlength' => '50'],
                    'label' => 'Objet de la mission',
                    'constraints' => [new Assert\Length(['min' => 2, 'max' => 50]), new Assert\NotBlank()]
                ])
                ->add('Bailleur', EntityType::class, [
                    'class' => Bailleur::class,
                    'placeholder' => 'Choisissez un Bailleur',
                    'attr' => ['class' => 'form-control', 'data-live-search' => 'true'],
                    'label' => 'Bailleur de financement'
                ]);
        }
    

     // ✅ Ajouter chauffeur et véhicule uniquement si mission est "national"
        $formModifier = function ($form, ?Mission $mission) {
            if ($mission && $mission->getType() === 'NATIONAL') {
                $form->add('Vehicule', EntityType::class, [
                    'class' => Vehicule::class,
                    'placeholder' => 'Choisissez un Vehicule',
                    'attr' => ['class' => 'form-control', 'data-live-search' => 'true'],
                    'label' => 'Vehicule libre',
                    'required' => false,
                    'constraints' => [new VehiculeDisponibilite()],
                ]);

                $form->add('Chauffeur', EntityType::class, [
                    'class' => Chauffeur::class,
                    'placeholder' => 'Choisissez un Chauffeur',
                    'attr' => ['class' => 'form-control', 'data-live-search' => 'true'],
                    'label' => 'Chauffeur libre',
                    'required' => false,
                    'constraints' => [new ChauffeurDisponibilite()],
                ]);
            }
        };

        // Cas édition : mission déjà connue
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $evenement = $event->getData();
            $form = $event->getForm();

            if ($evenement && $evenement->getMission()) {
                $formModifier($form, $evenement->getMission());
            }
        });

        // Cas création : quand mission choisie
        if ($builder->has('mission')) {
            $builder->get('mission')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    $mission = $event->getForm()->getData();
                    $formModifier($event->getForm()->getParent(), $mission);
                }
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'from_mission' => false, // par défaut non
        ]);
    }

}
