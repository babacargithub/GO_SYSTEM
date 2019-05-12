<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Utils;
use GO\ShopBundle\Entity\Vente;
use Symfony\Component\Debug\Exception\FatalErrorException as FatalError;

/**
 * Description of VenteInspector
 *
 * @author LBC
 */
class VenteInspector {
    //put your code here
    protected $vente;
    // ces constances permettent de définir le dégré de sévérité de la suspucion sur la vente
    const FLAGGED=-1;
    const NOT_SUSPECTED=0;
    const SUSPECTED=1;
    const LITTLE_SUSPECTED=2;
    const VERY_SUSPECTED=3;
    const HIGHLY_SUSPECTED=4;
    const EXTREMELY_SUSPECTED=5;
            function __construct(Vente $vente) {
        $this->vente = $vente;
    }
    // Cette fonction a pour role de vérifier si le produit vendu a été vendu avec un prix normal en le 
    //comparant avec le prix d'achat du produit 
    // si le prix de vente est inférieur au prix de revient la fonction renvoie supect 
    //sinon elle renvoie non suspect
    // le degré de souspicion varie en fonction de l'écart entre le prix d'achat du produit et le prix vendu
    public function inspect()
    {
        if(is_null($this->vente))
        {
            throw new FatalError(" La vente à analyser n'est pas définie!");
        }
        $suspected=false;
        $suspectedDegree=null;
        $produitPrixAchat=intval($vente->getProduit()->getPrixAchat());
        $produitPrixVendu=intval($vente->getPrixVente());
        
        if($produitPrixAchat==$produitPrixVendu)
            return self::FLAGGED;
        if($produitPrixVendu<$produitPrixAchat)
        {
            return self::SUSPECTED;
        }
        
        //===========
        return self::NOT_SUSPECTED;
        
        
    }

    
}
