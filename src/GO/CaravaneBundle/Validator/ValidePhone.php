<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CaravaneBundle\Validator;
use Symfony\Component\Validator\Constraint;
/**

 * @Annotation
 */
class ValidePhone extends Constraint{
    //put your code here
    
    public $message="Le numéro téléphone %telephone% n'est pas valide! Il doit commencer par 77, 78, 70 ou 76";
}
