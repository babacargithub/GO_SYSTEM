<?php

namespace GO\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PhoneNumber extends Constraint
{
    public $message ="Le numéro de téléphone doit être un téléphone mobile sénégalais";
            
}