<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ClientBundle\Form\DataTransformer;

use GO\ClientBundle\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
 
class TelephoneToCompteTransformer implements DataTransformerInterface{
    //put your code here
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Transforms an object (client) to a string.
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($compte) {
       
        if(null==$compte)
        {
            return "";
        }
            else
            {
                if($compte instanceof Compte)
                    return $compte->getNumber();
                else
                    return "";
            }
        
        
    }
    public function reverseTransform($tel) {
        $client=$this->manager->getRepository('GOClientBundle:Client')->findOneByTel(trim($tel));
          if($client==null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun client avec le téléphone "%s" trouvé!',
                $tel
            ));
        }
        $compte=$this->manager->getRepository('GOClientBundle:Compte')->findOneByClient(trim($client->getId()));
        if($compte==null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun compte n\'appartient au client avec le téléphone "%s"!',
                $tel
            ));
        }
        return $client;
        
    }
     

}
