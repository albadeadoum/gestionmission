<?php

// src/Validator/ChauffeurDisponibilite.php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ChauffeurDisponibilite extends Constraint
{
    public $message = 'Le chauffeur "{{ chauffeur }}" n\'est pas disponible du {{ debut }} au {{ fin }}.';
}
