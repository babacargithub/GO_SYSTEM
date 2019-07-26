<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\CaravaneBundle\Entity\Evenement;
use GO\CaravaneBundle\Form\EvenementType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EvenementController extends MainController {
    //put your code here
    public function indexAction(Request $req)
    {
       $event=new Evenement();
       $form= $this->createForm(new EvenementType(), $event);
       return $this->render('GOCaravaneBundle:Evenement:index.html.twig', array('form'=>$form->createView())); 
    }
    public function menuVerticalAction(Request $req)
    {
       $liste =array(array("libelle"=>"Créer évenement", "id"=>"", "href"=> $this->generateUrl('go_caravane_event_index')),
           array("libelle"=>"Evenement En cours", "id"=>"", "href"=>"event_en_cours.golob"),
           array("libelle"=>"Liste Evenements", "id"=>"", "href"=>"event_show.golob"),
           array("libelle"=>"Recherche", "id"=>"", "href"=>"event_recherche.golob"),
           array("libelle"=>"Statistiques", "id"=>"", "href"=>"depart_stat.golob"),
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    public function addAction(Request $req)
    {
        
        $event=new Evenement();
       $form= $this->createForm(new EvenementType(), $event);
       $form->bind($req);
       if($form->isValid())
       {
           $em= $this->em();
           $em->persist($event);
           $em->flush();
           $this->msg="Evènement ajouté avec succès!";
       }else
       {
          return $this->render("GOCaravaneBundle:Evenement:index.html.twig", array("form"=>$form->createView()));
       
       } 
       return $this->sendResponse(array("view"=>"GOCaravaneBundle::layout.html.twig","msg"=>$this->msg));
      
    }
    public function showAction(Request $req)
    {
        $events= $this->getRepo('Evenement')->findAll();
        
        return $this->render('GOCaravaneBundle:Evenement:show.html.twig', array("events"=>$events));
    }
    /**
     * 
     * @param Request $req
     * @param Evenement $event
     * @return type
     * @Route("event/{id}/update", name="event_update")
     */
    public function updateAction(Request $req, Evenement $event)
    {
        
        $event= $this->getRepo('Evenement')->find($req->get('event'));
        $form= $this->createForm(new EvenementType(), $event);
       $form->handleRequest($req);
       if($form->isSubmitted()&& $form->isValid())
       {
           $em= $this->em();
           $em->persist($event);
           $em->flush();
           return $this->render('@GOCaravane/Evenement/show.html.twig', array("events"=>$this->getRepo('Evenement')->findAll()));
   
       }
          return $this->render('@GOCaravane/Evenement/_edit.html.twig', array("form"=>$form->createView(),"event"=>$event));
   
       
    }
    public function deleteAction(Request $req)
    {
        $event= $this->getRepo('Evenement')->find($req->get('event'));
        $em= $this->em();
        $em->remove($event);
        $em->flush();
     
    }
    public function prolongerAction(Request $req)
    {
        $event= $this->getRepo('Evenement')->find($req->get('event'));
        $event->setDateEnd($req->get('new_date_end'));
        $em= $this->em();
        $em->persist($event);
        $em->flush();
     
    }
}
