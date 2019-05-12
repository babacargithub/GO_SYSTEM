<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaisseBundle\Controller;
use GO\CaisseBundle\Entity\Caisse;
use GO\CaisseBundle\Entity\Shop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Shop controller.
 *
 * @Route("authenticator")
 */
class AuthenticatorController extends MainController{
    // cette methode est exécuter quand l'utilisateur choisit une application, elle se chargera de vérifier s'il a accès
    // à l'application choisi ou nom
    
    /**
     * 
     * @param \GO\CaisseBundle\Entity\Caisse $caisse
     * @param Request $req
     * @return type
     * @Route("/caisse_access/{id}/authenticate", name="authenticate_caisse_access")
     */
    public function caisseAccessAuthenticateAction(Caisse $caisse,Request $req)
    {
        $session = $this->get('session');
        $caissier= $this->getRepo('Caissier')->findOneByUserAccount($this->getUser()->getId());
        $caisses= $this->getRepo('Caisse')->findAll();
        $ShopAccess=$this->em()->getRepository('GOCaisseBundle:CaisseUser')->findOneBy(array('caissier'=>$caissier, "caisse"=>$caisse));
        $responseParams=array('errorMsg'=>null,"caisses"=>$caisses); 
        if(null!==$ShopAccess)
            {
               
                    $session->set('connected_caisse', $caisse);
                    $session->set('caisse_id', $caisse->getId());
                    $successMsg="Authentification réussie! Vous êtes autorisés à accéder à la caisse sélectionnée";
                $this->addFlash('success', $successMsg);
                return $this->redirectToRoute("go_caisse_pro_homepage");
            }else
            {
                $errorMsg="Vous n'êtes pas autorisé à accéder la caisse séléctionnée!";
                $this->addFlash('error', $errorMsg);
                $responseParams['errorMsg']=$errorMsg;
                
            }
           
             
   return $this->render('@GOCaisse/caisse_selection.html.twig',$responseParams);
            
    }
    // cette methode est exécuter quand l'utilisateur choisit une application, elle se chargera de vérifier s'il a accès
    // à l'application choisi ou nom
    /**
     * 
     * @param \GO\CaisseBundle\Entity\Caisse $caisse
     * @param Request $req
     * @return type
     * @Route("/shop_access/{id}/authenticate", name="authenticate_shop_access")
     */
    public function shopAccessAuthenticateAction(Shop $shop,Request $req)
    {
        $shopRepo=$this->getDoctrine()->getManager()->getRepository("GOCaisseBundle:Shop");
      $shops=$shopRepo->findAll();
      
     $session = $this->get('session');
      
          $ShopAccess=$this->em()->getRepository('GOCaisseBundle:ShopUser')->findOneBy(array('user'=>$this->getUser(), "shop"=>$shop));
            if(null!==$ShopAccess)
            {
               
                    $session->set('connected_shop', $shop);
                    $session->set('shop_id', $shop->getId());
                return $this->redirectToRoute("working_caisse_selection");
            }else
            {
        return $this->render('@GOCaisse/shop_selection.html.twig', array("shops"=>$shops,'errorMsg'=>"Vous n'êtes pas autorisé à accéder la boutique séléctionnée!"));
      
            }
             
             
   return $this->render('@GOCaisse/shop_selection.html.twig', array("shops"=>$shops,'errorMsg'=>"Vous n'êtes pas autorisé à accéder à l'application Shop"));
            
    }
    public function caisseAccessLogger(Caisse $caisse)
    {
        
            
    }
}
