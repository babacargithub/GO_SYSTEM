<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\CaravaneBundle\Entity\Chauffeur;
use GO\CaravaneBundle\Form\ChauffeurType;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\CaravaneBundle\Utils\Constants as Cons;
/**
 * Description of DepartController
 *
 * @author hp
 */
class ChauffeurController extends MainController{
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Créer évenement", "id"=>"", "href"=>"event.golob"),
           array("libelle"=>"Départs en cours", "id"=>"", "href"=>"depart_show.golob"),
           array("libelle"=>"Liste départs", "id"=>"", "href"=>"depart_show.golob"),
           );
        return $this->render('GOCaravaneBundle:Depart:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * @param Request $req
     * @return type
     * @Route("chauffeur_index.golob", name="chauffeur_index")
    */
    public function indexAction(Request $req)
    {
        $chauffeur=new Chauffeur;
       $form= $this->createForm(new ChauffeurType(), $chauffeur);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                
            try
            {$em= $this->em();
            $em->persist($chauffeur);
            $em->flush();
            } catch (\Exception $e)
            {
                return $e;
            }
           return $this->render('GOCaravaneBundle::layout.html.twig', array('form'=>$form->createView())); 
        
            } else
            return $this->render('GOCaravaneBundle:Depart:chauffeur_index.html.twig', array('form'=>$form->createView())); 
        
        }else
        {
      
      return $this->render('GOCaravaneBundle:Depart:chauffeur_index.html.twig', array('form'=>$form->createView())); 
        }
    }
    public function addAction(Request $req)
    {
    }
  
}
