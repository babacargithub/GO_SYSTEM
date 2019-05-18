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
