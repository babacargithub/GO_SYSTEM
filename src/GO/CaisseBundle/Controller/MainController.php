<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaisseBundle\Controller;

use GO\MainBundle\Controller\BaseController;
use GO\CaisseBundle\Entity\Shop;
use GO\CaisseBundle\Entity\Caisse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Main controller.
 *
 * @Route("general")
 */
class MainController extends BaseController{
    //put your code here
    protected $em;
    protected $msg=null;
    protected $errorMsg=null;
    public function em() {
      
      return $this->getDoctrine()->getManager();
    }
    // shortcut function to get the enitiy manager// Fonction raccourci pour récupérer l'Entity Manager Repository
    public function getRepo($class)
    {
        return $this->getDoctrine()->getRepository('GOCaisseBundle:'.$class);
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
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/", name="go_caisse_pro_homepage")
     */
    public function indexAction(Request $req)
    {
     
      return $this->render('@GOCaisse/layout.html.twig');
   
    }
    //fonction raccourici pour récupérer la boutique à laquelle l'utilisateur courant est connecté
    public function getShop()
    {
        //return $this->getUser->getShop();
        $session=$this->get('session');
       
        if($session->has('shop_id')&& is_numeric($session->get('shop_id')))
        {
            $shop=$this->getRepo('Shop')->find($session->get('shop_id'));
            if($shop!==null&& $shop instanceof Shop)
            {
            return $shop;
            }
        
        }
        
          throw   new NotFoundHttpException("Grave Erreur! Aucune connexion sur une boutique! L'application est arrêtée!");
        
    }
   
    public function getActiveCaissier()
    {
        $caissier= $this->getRepo('Caissier')->findOneByUserAccount($this->getUser()->getId());
        if($caissier==null)
        {
            throw new NotFoundHttpException('Aucun caissier trouvé');
        }
        return $caissier;
       
    }
    //fonction raccourici pour récupérer la caisse de la boutique à laquelle l'utilisateur courant est connecté
  
    public function getCaisse()
    {
        $session=$this->get('session');
       
        if($session->has('caisse_id')&& is_numeric($session->get('caisse_id')))
        {
            $caisse=$this->getRepo('Caisse')->find($session->get('caisse_id'));
            if($caisse!==null&& $caisse instanceof Caisse)
            {
            return $caisse;
            }
        
        }
        
          throw   new NotFoundHttpException("Erreur Fatale! Caisse Non Trouvée! Le script est arrêté!");
        
   
    }
    public function getActiveCaisse()
    {
        return $this->getCaisse();
    }
   
    // quand l'utilisateur se connecte et après qu'il a identifié, on lui affiche la liste des shops s'il est 
    // affecté à plusieurs boutiques. Il devera
    //alors sélécrionner une shop et sse connecter à cette dernière
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/working_caisse_selection/", name="working_caisse_selection")
     **/
    public function caisseSelectionAction(Request $req)
    {
     
      return $this->render('@GOCaisse/caisse_selection.html.twig', array("caisses"=>$this->em()->getRepository('GOCaisseBundle:Caisse')->findAll()));
   
    }
    
}
