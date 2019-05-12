<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Utils;
use GO\MainBundle\Utils\CustomValidator as BaseValidator;

/**
 * Description of TelephoneValidator
 *
 * @author hp
 */
class CustomValidator extends BaseValidator{
    //put your code here
    
public static function isValideMontant($montant)
{
    if(!is_numeric($montant) || $montant <=0 || strlen($montant)<2)
    {
        return false;
    } else {
        return true;
    }
}

}
