<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;

use GO\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GO\ShopBundle\Entity\Shop;

class MainController extends BaseController{
    //put your code here
    protected $em;
    protected $msg=null;
    protected $errorMsg=null;
    public function em() {
      
      return $this->getDoctrine()->getManager();
    }
    // shortcut function to get the enitiy manager// Fonction raccourci pour récupérer l'Entity Manager
    public function getRepo($class)
    {
        $main_bundle_entities=array('Client', 'CarteKheweul', 'Promo', 'RemiseCarte');
        if(in_array($class, $main_bundle_entities))
        return $this->getDoctrine()->getRepository('GOMainBundle:'.$class);
        elseif($class=="User")
         return $this->getDoctrine()->getRepository('GOUserBundle:'.$class);
        else
        return $this->getDoctrine()->getRepository('GOShopBundle:'.$class);
    }
    
    public function setMessage($msg)
        {
            return json_encode(array("code"=>1, "message"=>$msg));
        }
    public function setErrorMessage($error)
        {
             return json_encode(array("code"=>0, "message"=>$error));
        }
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"A propos de version 2.0.0", "id"=>"", "href"=>"achat.golob"),
           array("libelle"=>"Documentation Shop", "id"=>"", "href"=>"achat_fact_index.golob", "exception"=>true),
           array("libelle"=>"Aide", "id"=>"", "href"=>"achat_show_today.golob")
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    public function indexAction(Request $req)
    {
     
      return $this->render('GOShopBundle::layout.html.twig');
   
    }
    //fonction raccourici pour récupérer la boutique à laquelle l'utilisateur courant est connecté
    public function getShop()
    {
        //return $this->getUser->getShop();
        $session=$this->get('session');
        $shop=null;
        if($session->has('shop_id')&& is_numeric($session->get('shop_id')))
        $shop=$this->getRepo('Shop')->find($session->get('shop_id'));
        if($shop!==null&& $shop instanceof Shop)
        {
        return $shop;
        }
        else
        {
          throw   new NotFoundHttpException("Grave Erreur! L'Object Shop n'est pas défini! L'application est arrêtée!");
        }
    }
    public function getStock(\GO\ShopBundle\Entity\Produit $Produit)
    {
        $stock= $this->getRepo('Stock')->findOneBy(array("produit"=>$Produit, "shop"=> $this->getShop()));
        if(null!==$stock)
        {
            return $stock;
        }else
        {
            throw new \RuntimeException('Stock du produit introuvable');
        }
    }
    //fonction raccourici pour récupérer la caisse de la boutique à laquelle l'utilisateur courant est connecté
  
    public function getCaisse()
    {
        //return $this->getUser->getShop();
        return $this->getRepo('Caisse')->findOneByShop($this->getShop());
    }
    // quand l'utilisateur se connecte et après qu'il a identifié, on lui affiche la liste des shops s'il est 
    // affecté à plusieurs boutiques. Il devera
    //alors sélécrionner une shop et sse connecter à cette dernière
    public function shopSelectionAction(Request $req)
    {
     
      return $this->render('GOShopBundle::shop_selection.html.twig', array("shops"=>$this->em()->getRepository('GOShopBundle:Shop')->findAll()));
   
    }
    // cette methode est exécuter quand l'utilisateur choisit une application, elle se chargera de vérifier s'il a accès
    // à l'application choisi ou nom
    public function shopAccessAuthenticateAction(Shop $shop,Request $req)
    {
        
     $Authenticator= $this->get('go.authenticator_listener');
     $app= strtoupper($req->get('app'));
     
     $session = $this->get('session');
      if($Authenticator->authenticateApp($this->getUser(), "ROLE_AG_BOUT"))
        {
          $ShopAccess=$this->em()->getRepository('GOShopBundle:UserShop')->findOneBy(array('user'=>$this->getUser(), "shop"=>$shop));
            if(null!==$ShopAccess)
            {
               
                    $session->set('connected_shop', $shop);
                    $session->set('shop_id', $shop->getId());
                return $this->redirect(".");
            }else
            {
        return $this->render('GOShopBundle::shop_selection.html.twig', array('errorMsg'=>"Vous n'êtes pas autorisé à accéder la boutique séléctionnée!"));
      
            }
             }
             
   return $this->render('GOMainBundle::app_selection.html.twig', array('errorMsg'=>"Vous n'êtes pas autorisé à accéder à l'application Shop"));
            
    }
}
