<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use GO\MainBundle\AppAuthenticator\Authenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController{
    //put your code here
    protected $em;
    protected $msg=null;
    protected $errorMsg=null;
    public function em() {
      
      return $this->em= $this->getDoctrine()->getManager();
    }
    public function save($object)
    {
        $em=$this->em();
        $em->persist($object);
        try{
            $em->flush();
            return true;
        } catch (Exception $ex) {
            return $ex;
        }
        
    }
    public function delete($object)
    {
        $em=$this->em();
        $em->remove($object);
        try{
            $em->flush();
            return true;
        } catch (Exception $ex) {
            return $ex;
        }
        
    }

    public function getRepo($class)
    {
        if($class=="User")
         return $this->getDoctrine()->getRepository('GOUserBundle:'.$class);
        else
        return $this->getDoctrine()->getRepository('GOMainBundle:'.$class);
        
    }
   //fonction pour envoyer des messages flash selon que la requete est de type ajax ou pas
    public function sendResponse(array $params=array())
    {
        if($this->getRequest()->isXmlHttpRequest())
        {
            $response=new Response();
            $response->headers->set("Content-Type", "application/json");
            if(isset($params['errorMsg'])&& !is_null($params['errorMsg']))
            {
                $response->setContent($this->setErrorMessage($params['errorMsg']));
            }elseif(isset($params['msg'])&&!is_null($params['msg']))
            {
            $response->setContent($this->setMessage($params['msg']));
            }
             return $response;
        } else {
            if(isset($params['view']))
            {
                    if(isset($params['responseVars']) && is_array($params['responseVars']))
                    {
                    return $this->render($params['view'], $params['responseVars']);
                    }
                    else{
                        return $this->render($params['view']);
                    }
            } else {
            return new Response('Une requêt non AJAX doit inclure une vue. Aucun view renseigné dans le controller. Ce message est renvoyé par moi-meme Fonction SendResponse') ;   
            }
            
        }
    }
    public function setMessage($msg)
        {
            return json_encode(array("type"=>"success","code"=>1, "message"=>$msg));
        }
    public function setErrorMessage($error)
        {
             return json_encode(array("type"=>"error","code"=>0, "message"=>$error));
        }
    public function indexAction(Request $req)
    {
     
      return $this->render('GOMainBundle::layout.html.twig');
   
    }
    // quand l'utilisateur se connecte et après qu'il a identifié, on lui affiche la liste des applications. Il devera
    //alors sélécrionner une applicartion et sse connecter à cette dernière
    /** 
     * @Route("select_app", name="go_main_app_selection")
     */
    public function appSelectionAction(Request $req)
    {
     
      return $this->render('@GOMain/app_selection.html.twig');
   
    }
    // cette methode est exécuter quand l'utilisateur choisit une application, elle se chargera de vérifier s'il a accès
    // à l'application choisi ou nom
    /**
     * @Route("app/authenticate/{app}", name="go_main_app_authentication")
     */
    public function appAuthenticateAction(Request $req)
    {
     $Authenticator= $this->get('go.authenticator_listener');
     $app= strtoupper($req->get('app'));
     
     $session = $this->get('session');
      switch ($app)
         {case "SHOP":
            if($Authenticator->authenticateApp($this->getUser(), "ROLE_AG_BOUT"))
             {
             
            $session->set('connected_app', "SHOP");
            $Shop=$this->em()->getRepository('GOShopBundle:UserShop')->findByUser($this->getUser());
            if(null!==$Shop)
            {
                if(count($Shop)>1)
                {
                    return $this->redirect($this->generateUrl('go_shop_selection'));
                }
                $session->set('connected_shop', $Shop[0]->getShop());
                $session->set('shop_id', $Shop[0]->getShop()->getId());
                return $this->redirect($this->generateUrl('go_shop_homepage'));
                   
            }else
            {
        return $this->render('GOMainBundle::app_selection.html.twig', array('errorMsg'=>"Vous n'êtes affecté à aucune boutique!"));
       }
             }
             break;
         case "CARAVANE":
             if($Authenticator->authenticateApp($this->getUser(), "ROLE_AG_CARAV"))
             {
                 $session->set('connected_app', "CARAVANE");
             return $this->redirect($this->generateUrl("go_caravane_homepage"));
             }
             break;
         case "SMS":
             if($Authenticator->authenticateApp($this->getUser(), "ROLE_AG_SMS"))
             {
                 $session->set('connected_app', "SMS");
             return $this->redirect($this->generateUrl("gosms_homepage"));
             }
             break;
         case "CONS":
             if($Authenticator->authenticateApp($this->getUser(), "ROLE_GP"))
             {
                 $session->set('connected_app', "CONS");
            return $this->redirect($this->generateUrl("cons_homepage"));
             }
             break;
         case "CAISSE_PRO":
             $session->set('connected_app', "CAISSE_PRO");
            return $this->redirect($this->generateUrl("working_caisse_selection"));
             
             break;
         case "ADMIN":
             if($Authenticator->authenticateApp($this->getUser(), "ROLE_ADMIN"))
             {
                 $session->set('connected_app', "ADMIN");
                 return $this->redirect($this->generateUrl("easyadmin"));
             }
             
         
         }
   return $this->render('GOMainBundle::app_selection.html.twig', array('errorMsg'=>"Vous n'êtes pas autorisé à accéder à cette application"));
            
    }
    
    public function render($viewFile, array $parameters = array(), Response $response = null)
    {
        $view= $this->view();
        $view->setTemplate($viewFile)
                ->setData($parameters)
                ->setTemplateData($parameters);
        return $this->handleView($view);
    }
    // testing template 
    /**
     * @Route("test_temp", name="test_temporary")
     */
    public function testTempAction(Request $req)
    {
        var_dump(\GO\MainBundle\Utils\SMSSender::getToken());die(); 
       $client= $this->getRepo('Client')->findOneByTel($req->get("fName"));
        
        return new Response('Client: '.$client->getPrenom(). ' '.$client->getNom());
    }
    // testing template 
    /**
     * @Route("remote_data", name="test_template")
     */
    public function getDataRomeAction(Request $req)
    
    {
       
    }
    
}
