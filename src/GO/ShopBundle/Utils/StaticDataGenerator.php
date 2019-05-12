<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Utils;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;
use GO\ShopBundle\Utils\Constants as Cons;

/**
 * Description of StaticDataGenerator
 *
 * @author LBC
 */
class StaticDataGenerator {
    //put your code here
    protected $em;
    public function __construct(EntityManager $em) {
        $this->em=$em ;
      
    }
     public function updateCodeBarFile()
    {
        $fileSystem=new Filesystem();
        $shops= $this->em->getRepository('GOShopBundle:Shop')->findAll();
           $content='var produits=[';
        foreach($shops as $shop)
        {
            $achats= $this->em->getRepository('GOShopBundle:Achat')->getListeAchat($shop, Cons::DATE_INTERVALLE,null,"2018-09-01");
            foreach($achats as $achat)
            {
            $content.='{"codeBar":"'.$achat->getCodeBar().'","nom":"'.$achat->getProduit()->getNom().'","prixAchat":"'.$achat->getPrixUnit().'","prixVente":"'.$achat->getPrixVente().'"},';
            }
        
        }
        $content.="]";
        $fileSystem->dumpFile("js/produits.js", $content);
        
        return true;
    }
     public function generateAucoCompleteProduitsFile()
    {
        $fileSystem=new Filesystem();
        $produits= $this->em->getRepository('GOShopBundle:Produit')->findAll();
           $content='var produits_autocomplete="';
        foreach($produits as $produit)
        {
            
            $content.=$produit->getNom().',';
            
        
        }
        $content.='"';
        $fileSystem->dumpFile("js/produits_autocomplete.js", $content);
        
        return true;
    }
}
