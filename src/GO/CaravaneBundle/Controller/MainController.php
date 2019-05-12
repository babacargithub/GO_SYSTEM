<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;

use GO\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MainController extends BaseController{
    //put your code here
    protected $em;
    protected $msg=null;
    protected $errorMsg=null;
    public function em() {
      
      return $this->em= $this->getDoctrine()->getManager();
    }
    public function getRepo($class)
    {
        $main_bundle_entities=array('CarteKheweul', 'Promo', 'RemiseCarte');
        if(in_array($class, $main_bundle_entities))
        return $this->getDoctrine()->getRepository('GOMainBundle:'.$class);
        elseif($class=="User")
         return $this->getDoctrine()->getRepository('GOUserBundle:'.$class);
        else
        return $this->getDoctrine()->getRepository('GOCaravaneBundle:'.$class);
    }
    public function sendResponse(array $params=array())
    {
        if($this->getRequest()->isXmlHttpRequest())
        {
            $response=new Response();
            $response->setContent(json_encode(array("code"=>1, "msg"=>'Test content')));
            if(isset($params['msg'])&&!is_null($params['msg']))
            {
            $response->setContent($this->setMessage($params['msg']));
            }if(isset($params['errorMsg'])&& !is_null($params['errorMsg']))
            {
                $response->setContent($this->setErrorMessage($params['errorMsg']));
            }
             return $response;
        } else {
            if(isset($params['responseVars']) && is_array($params['responseVars']))
            {
            return $this->render($params['view'], $params['responseVars']);
            }
            else{
                return $this->render($params['view']);
            }
            
        }
    }
    public function setMessage($msg)
        {
            return json_encode(array("code"=>1, "message"=>$msg));
        }
    public function setErrorMessage($error)
        {
             return json_encode(array("code"=>0, "message"=>$error));
        }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/", name="go_caravane_homepage")
      */
    public function indexAction(Request $req)
    {
     
      return $this->render('GOCaravaneBundle::layout.html.twig');
   
    }
}
