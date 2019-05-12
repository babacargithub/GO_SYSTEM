<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\SMSBundle\Controller;

use GO\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Entity\Shop;

class MainController extends BaseController{
    
    // shortcut function to get the enitiy manager// Fonction raccourci pour récupérer l'Entity Manager
    public function getRepo($class)
    {
        $main_bundle_entities=array('Client', 'CarteKheweul', 'Promo', 'RemiseCarte');
        if(in_array($class, $main_bundle_entities))
        return $this->getDoctrine()->getRepository('GOMainBundle:'.$class);
        elseif($class=="User")
         return $this->getDoctrine()->getRepository('GOUserBundle:'.$class);
        else
        return $this->getDoctrine()->getRepository('GOSMSBundle:'.$class);
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/", name="sms_index")
     */
    public function indexAction(Request $req)
    {
     
      return $this->render('GOSMSBundle::layout.html.twig');
   
    }
    
    //fonction raccourici pour récupérer la caisse de la boutique à laquelle l'utilisateur courant est connecté
  
    public function getCaisse()
    {
        //return $this->getUser->getShop();
        return $this->getRepo('Caisse')->findOneByShop($this->getShop());
    }
    
    
}
