<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ClientBundle\Form\DataTransformer;

use GO\ClientBundle\Entity\CompteClient;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
 
class NumCompteToIdTransformer implements DataTransformerInterface{
    //put your code here
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Transforms an object (compte) to an account number .
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($compte) {
        if(null===$compte)
        {
            return "";
        }
            else
            {
                if($compte instanceof CompteClient)
                {
                    return $compte->getNumber ();
                }
                else{
                return "";
                
                }
            }
        
        
    }
    public function reverseTransform($number) {
        $compte=$this->manager->getRepository('GOClientBundle:CompteClient')->findOneByNumber(trim($number));
        if($compte==null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun compte avec ce numéro "%s" trouvé!',
                $number
            ));
        }
        return $compte;
        
    }
     

}
