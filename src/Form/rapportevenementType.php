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
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class rapportevenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add('imageFile', FileType::class, [
                'label' => 'Image du Véhicule',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false, // facultatif, à modifier selon vos besoins
                'attr' => [
                    
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
