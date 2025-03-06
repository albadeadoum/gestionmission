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

class AssuranceTypeT extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numero')
            ->add('debut', null, [
                'widget' => 'single_text'
            ])
            ->add('fin', null, [
                'widget' => 'single_text'
            ])
            ;

        

            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $assurance = $event->getData();
                $form = $event->getForm();
            
                if ($form->has('type')) {
                    $type = $form->get('type')->getData();
                    
                    if ($type === 'vehicule') {
                        $assurance->setMoto(null); // ✅ Supprime moto si un véhicule est sélectionné
                    } elseif ($type === 'moto') {
                        $assurance->setVehicule(null); // ✅ Supprime véhicule si une moto est sélectionnée
                    } else {
                        $assurance->setVehicule(null);
                        $assurance->setMoto(null);
                    }
                }
            });
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}



