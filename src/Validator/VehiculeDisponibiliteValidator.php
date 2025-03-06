<?php

// src/Validator/VehiculeDisponibiliteValidator.php

namespace App\Validator;

use App\Entity\Evenement;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class VehiculeDisponibiliteValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $evenementRepository = $this->entityManager->getRepository(Evenement::class);

        // Vérifier la disponibilité du véhicule
        $form = $this->context->getRoot();
        $evenement = $form->getData(); 
        $debut = $evenement->getDebut();
        $fin = $evenement->getFin();

        $vehicule = $value;
        if (!$evenementRepository->isVehiculeAvailable($vehicule, $debut, $fin)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ vehicule }}', $vehicule)
                ->setParameter('{{ debut }}', $debut->format('d-m-Y'))
                ->setParameter('{{ fin }}', $fin->format('d-m-Y'))
                ->addViolation();
        }
    }
}
