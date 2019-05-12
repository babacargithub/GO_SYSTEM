<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Utils;

/**
 * Description of TelephoneValidator
 *
 * @author hp
 */
class CustomValidator {
    //put your code here
    public function isValideTelephone($tel){
			if(is_numeric($tel) && preg_match("#^7[7680]{1}[0-9]{7}$#", $tel))
                        {
			return true;
			} 
			else
			{
			return false;
			}
}
public static function isValideMontant($montant)
{
    if(!is_numeric($montant) || $montant <=0 || strlen($montant)<2)
    {
        return false;
    } else {
        return false;
    }
}
}
