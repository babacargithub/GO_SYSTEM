<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Form\DataTransformer;

use GO\CaravaneBundle\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
 
class TelephoneToClientTransformer implements DataTransformerInterface{
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
    public function transform($client) {
        if(null===$client)
        {
            return "";
        }
            else
            {
                if($client instanceof Client)
                    return $client->getTel ();
                else
                    return "";
            }
        
        
    }
    public function reverseTransform($tel) {
        $client=$this->manager->getRepository('GOCaravaneBundle:Client')->findOneByTel(trim($tel));
        if($client==null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun client avec le téléphone "%s" trouvé!',
                $tel
            ));
        }
        return $client;
        
    }
     

}
