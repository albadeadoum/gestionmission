<?php
// src/Validator/VehiculeDisponibilite.php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VehiculeDisponibilite extends Constraint
{
    public $message = ' Le véhicule "{{ vehicule }}" n\'est pas disponible du {{ debut }} au {{ fin }}.';
}
