<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use GO\MainBundle\Validator\Constraints\PhoneNumber;
/**
 * Description of PhoneNumberValidator
 *
 * @author LBC
 */
class PhoneNumberValidator extends ConstraintValidator{
    //put your code here
    public function validate($tel, Constraint $phoneNumberConstraint) {
        if(!$phoneNumberConstraint instanceof PhoneNumber)
        {
            throw new UnexpectedTypeException($phoneNumberConstraint, PhoneNumber::class);
        }
        if (null === $tel || '' === $tel) {
            return;
        }
        if(!preg_match("/^7[7680]{1}[0-9]{7}$/", $tel))
        {
            $this->context->buildViolation($phoneNumberConstraint->message)
                    ->addViolation();
        }
    }

}
