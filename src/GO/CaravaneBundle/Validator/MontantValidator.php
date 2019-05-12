<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * Description of ValidePhoneValidator
 *
 * @author hp
 */
class MontantValidator extends ConstraintValidator{
    //put your code here
    public function validate($montant, Constraint $constraint) {
        if(!is_numeric($montant) || $montant <=0)
        {
            $this->context->addViolation($constraint->message, array('%montant%'=>$montant));
        } 
    }
}
