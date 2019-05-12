<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Employe;
use GO\MainBundle\Form\EmployeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\CaravaneBundle\Utils\Constants as Cons;
/**
 * Description of DepartController
 *
 * @author hp
 */
class EmployeController extends BaseController{
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Enregistrer Nouveau", "id"=>"", "href"=>"event.golob"),
           array("libelle"=>"Listes", "id"=>"", "href"=>"depart_show.golob"),
           array("libelle"=>"Rechercher", "id"=>"", "href"=>"depart_show.golob"),
           );
        return $this->render('GOCaravaneBundle:Depart:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * @param Request $req
     * @return type
     * @Route("employe_index.golob", name="employe_index")
    */
    public function indexAction(Request $req)
    {
        $employe=new Employe;
       $form= $this->createForm(new EmployeType(), $employe);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                
            try
            {$em= $this->em();
            $em->persist($employe);
            $em->flush();
            } catch (\Exception $e)
            {
                return new Response($e->getMessage());
            }
           return $this->render('GOMainBundle::layout.html.twig', array('msg'=>"Employé crée avec succès")); 
        
            } else
            return $this->render('GOMainBundle:Employe:index.html.twig', array('form'=>$form->createView())); 
        
        }else
        {
      
      return $this->render('GOMainBundle:Employe:index.html.twig', array('form'=>$form->createView())); 
        }
    }
    public function addAction(Request $req)
    {
    }
  
}
