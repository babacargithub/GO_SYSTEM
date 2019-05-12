<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Form\DataTransformer;

use GO\ShopBundle\Entity\Produit;
use GO\ShopBundle\Entity\Shop;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\Session\Session;
 
class CodeBarToProduitTransformer implements DataTransformerInterface{
    //put your code here
    private $manager;
    private $session;

    public function __construct(ObjectManager $manager, Session $session)
    {
        $this->manager = $manager;
        $this->session=$session;
    }
    /**
     * Transforms an object (produit) to a string.
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($achat) {
        if(null===$achat)
        {
            return "";
        }
            else
            {
                if($achat instanceof Achat)
                    return $achat->getProduit()->getNom ();
                else
                    return "";
            }
        
        
    }
    public function reverseTransform($codeBarre) {
        $shop= $this->session->get('connected_shop');
        if(is_null($shop))
        {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Aucune boutique connectée');
        }
        $achat=$this->manager->getRepository('GOShopBundle:Achat')->findByCodeBar($shop, trim($codeBarre));
        if($achat===null)
        {
            throw new TransformationFailedException(sprintf(
                'Aucun produit avec le code barre "%s" trouvé!',$codeBarre));
        }
        return $achat;
        
    }
     

}
