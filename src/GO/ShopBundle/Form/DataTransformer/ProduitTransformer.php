<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Form\DataTransformer;

use GO\ShopBundle\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
 
class ProduitTransformer implements DataTransformerInterface{
    //put your code here
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Transforms an object (produit) to a string.
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($produit) {
        if(null===$produit)
        {
            return "";
        }
            else
            {
                if($produit instanceof Produit)
                    return $produit->getNom ();
                else
                    return "";
            }
        
        
    }
    public function reverseTransform($nom) {
        $produit=$this->manager->getRepository('GOShopBundle:Produit')->findOneByNom(trim($nom));
        if($produit===null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun produit avec le nom "%s" trouvé!',
                $nom
            ));
        }
        return $produit;
        
    }
     

}
