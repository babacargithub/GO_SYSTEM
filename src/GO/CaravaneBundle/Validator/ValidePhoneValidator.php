<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CaravaneBundle\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * Description of ValidePhoneValidator
 *
 * @author hp
 */
class ValidePhoneValidator extends ConstraintValidator{
    //put your code here
    public function validate($tel, Constraint $constraint) {
        if(!is_numeric($tel) || !preg_match("#^7[7680]{1}[0-9]{7}$#", $tel))
        {
            $this->context->addViolation($constraint->message, array('%telephone%'=>$tel));
        } 
    }
}
