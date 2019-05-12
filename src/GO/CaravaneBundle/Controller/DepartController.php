<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\CaravaneBundle\Entity\Client;
use GO\CaravaneBundle\Entity\Depart;
use GO\CaravaneBundle\Entity\BilanDepart;
use GO\CaravaneBundle\Entity\DepenseDepart;
use GO\CaravaneBundle\Entity\HeureDepart;
use GO\CaravaneBundle\Entity\Evenement;
use GO\CaravaneBundle\Form\ClientType;
use GO\CaravaneBundle\Form\DepartType;
use GO\CaravaneBundle\Form\BilanDepartType;
use GO\CaravaneBundle\Form\DepartEditType;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use GO\CaravaneBundle\Utils\Constants as Cons;
/**
 * Description of DepartController
 *
 * @author hp
 */
class DepartController extends MainController{
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Créer Un départ", "id"=>"", "href"=>$this->generateUrl("go_caravane_depart_index")),
           array("libelle"=>"Départs En Cours", "id"=>"", "href"=>$this->generateUrl("go_caravane_depart_show")),
           array("libelle"=>"Départs Récents", "id"=>"", "href"=>$this->generateUrl("departs_recent")),
           array("libelle"=>"Afficher les Bilans", "id"=>"", "href"=>$this->generateUrl("bilan_des_departs")));
           
       $events=$this->getRepo('Evenement')->getEventsEnCours()->getQuery()->getResult();
       if(count($events)>0)
       {
        foreach($events as $event)
        {   
        $item=array("libelle"=>"Tous les départs", "id"=>"", "href"=>$this->generateUrl("all_departs_event", array('id'=>$event->getId())));
        array_push($liste, $item);
        }
        
       }else
       {
           
       }
            
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    public function indexAction(Request $req)
    {
      $depart=new Depart();
       $form= $this->createForm(new DepartType(), $depart);
      return $this->render('GOCaravaneBundle:Depart:index.html.twig', array('form'=>$form->createView())); 
    }
    public function addAction(Request $req)
    {
        $msg=null; $errorMsg=null;
        $depart=new Depart();
       $form= $this->createForm(new DepartType(), $depart);
       $form->bind($req);
       //--- reglé l'heure de départ de la caravne 
       if($form->getData()->getHoraire()==1)
       {
       if($form->getData()->getTrajet()==2)
       $form->getData()->getDate()->setTime(03,59);
           else
       $form->getData()->getDate()->setTime(23,59);
       }
       elseif($form->getData()->getHoraire()==2)
       {
       $form->getData()->getDate()->setTime(15,30);
       }
        if($form->isValid())
       {
            
            $pointsDept= $this->getRepo('PointDepart')->findByTrajet($depart->getTrajet());
            $heure="getHeurePointDep";
            if($depart->getHoraire()==2)
                $heure="getHeurePointDepSoir";
            foreach($pointsDept as $pointDep)
            {
                $HeureDepart=new HeureDepart();
                $HeureDepart->setDepart($depart)
                ->setPointDep($pointDep)
                ->setArretBus($pointDep->getArretBus())
                ->setHeureDepart($pointDep->$heure());
                $depart->addHeuresDepart($HeureDepart);
            }
           $em= $this->em();
           $em->persist($depart);
           $em->flush();
           $msg='Le départ '.$depart->getLibelle().' a été ajouté avec succès!';
           
       }else
       {
          return $this->render('GOCaravaneBundle:Depart:index.html.twig', array('form'=>$form->createView()));
       }
       return $this->sendResponse(array('view'=>'GOCaravaneBundle:Depart:index.html.twig', 'msg'=>$msg));
    }
    public function deleteAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req);
        $em=$this->em();
        $em->remove($depart);
        $em->flush(); 
    }
    public function aupdateAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req->get('id_res'));
       $form= $this->createForm(new DepartType(), $depart);
       $form->bind($req);
       if($form->isValid())
       {
           $em= $this->em();
           $em->persisit($depart);
           $em->flush();
       }else
       {
           return;
       }
        
        
    }
    public function reporterAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req->get('id_res'));
        $depart->setDate($req->get('new_date'));
        $em=$this->em();
        $em->persist($depart);
        $em->flush();
        
        
    }
    public function cloturerResAction(Request $req)
    {
       $depart=$this->getRepo('Depart')->find($req->get('id_dep'));
        $depart->setClosRes(true);
        $em=$this->em();
        $em->persist($depart);
        $em->flush(); 
        return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',"msg"=>"Les réservations sont clôturées!"));
    }
    public function cloturerPayerAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req->get('id_dep'));
        $depart->setClosPaye(true);
        $em=$this->em();
        $em->persist($depart);
        $em->flush();  
        return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',"msg"=>"Les paiements sont clôturés pour le départ ".$depart->getLibelle()."!"));
    
    }
    /**
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_CARAV")
    */
    public function reopenPayerAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req->get('id_dep'));
        $depart->setClosPaye(false);
        $em=$this->em();
        $em->persist($depart);
        $em->flush(); 
      return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',"msg"=>"Les paiements sont à nouveau ouverts pour le départ ".$depart->getLibelle()."!"));
    
        
    }
    public function reopenResAction(Request $req)
    {
        $depart=$this->getRepo('Depart')->find($req->get('id_dep'));
        
        $depart->setClosRes(false);
        $em=$this->em();
        $em->persist($depart);
        $em->flush();  
     return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig',"msg"=>"Les réservations sont à nouveau ouvertes ".$depart->getLibelle()."!"));
    
    }
    //============================ Récuperation et affichage de données===================
    public function showAction(Request $req)
    {
       $liste=$this->getRepo('Depart')->getListeDeparts()->getQuery()->getResult();
       if($req->isXmlHttpRequest())
       return $this->render('GOCaravaneBundle:Depart:liste.html.twig', array('liste'=>$liste));
       else
       return $this->render('GOCaravaneBundle:Depart:show.html.twig', array('liste'=>$liste));
    }
    /**
     * @param Request $req
     * @return type
     * @Route("departs_recent.golob", name="departs_recent")
    */
    public function showRecentAction(Request $req)
    {
       $liste=$this->getRepo('Depart')->getListeDeparts(Cons::DEPART_TROIS_JR)->getQuery()->getResult();
       if($req->isXmlHttpRequest())
       return $this->render('GOCaravaneBundle:Depart:liste.html.twig', array('liste'=>$liste));
       else
       return $this->render('GOCaravaneBundle:Depart:show.html.twig', array('liste'=>$liste));
    }
    public function updateFormAction(Request $req)
    {
        $depart= new Depart();
        $depart=$this->getRepo('Depart')->find($req->get('id_dep'));
        $resForm= $this->createForm(new DepartEditType(), $depart);
      // return $this->sendResponse(array('view'=>'GOCaravaneBundle:Reservation:_edit_form.html.twig', 'form'=>$resForm->createView()));
       return $this->render('GOCaravaneBundle:Depart:_depart_edit_form.html.twig', array('form'=>$resForm->createView()));
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("update_depart-{id}.golob", name="update_depart")
     * @Secure(roles="ROLE_SUP_CARAV")
    */
    public function updateAction(Depart $depart,Request $req)
    {
        if($req->getMethod()=="POST")
        {
       // $depart= new Depart();
        $form= $this->createForm(new DepartEditType, $depart);
        $form->bind($req);
        $this->save($depart);
        $this->msg="Les modifications sont enregsitrées avec succès!";
         return $this->sendResponse(array('view'=>'GOCaravaneBundle::flash_message.html.twig', 'msg'=>$this->msg));
        }else
        {
        $resForm= $this->createForm(new DepartEditType(), $depart);
         return $this->render('GOCaravaneBundle:Depart:_depart_edit_form.html.twig', array('form'=>$resForm->createView(), "depart"=>$depart));
        
        }
    }
    public function etatDepartsAction()
    {
        $Depart=$this->getRepo('Depart');
        $Payer=$this->getRepo('Payer');
        $Res=$this->getRepo('Reservation');
        $departs= $Depart->getListeDeparts()->getQuery()->getResult();
        $chiffres=array();
        foreach($departs as $depart)
        { 
          $ar=array(
              'depart'=>$depart, 
              'total'=>(int) $Payer->getTotalPayeDepart($depart->getId()),
              'nombrePaye'=>(int) $Payer->getNombrePaye(Cons::DEPART,$depart->getId()),
               'nombre'=>(int)$Res->getNombreInscritDepart($depart->getId()),
               'nombreOnline'=>(int)$Res->getNombreInscritDepartOnline($depart)
              ) ;
          array_push($chiffres, $ar);
        }
        
        return $this->render('GOCaravaneBundle:Depart:etat_departs.html.twig', array('chiffres'=>$chiffres));
    
    }
    /**
     * @param Request $req
     * @return type
     * @Route("export_heures_depart-{id}.golob", name="export_heures_depart")
     * @Secure(roles="ROLE_SUP_CARAV")
    */
    public function exportHeuresPointDepAction(Depart $depart, Request $req)
    {
        foreach($depart->getHeuresDepart()->getIterator() as $ind=>$object)
        {
            
        }
    }
    /**
     * @param Request $req
     * @return type
     * @Route("update_heures_depart-{id}.golob", name="update_heures_depart")
     * @Secure(roles="ROLE_SUP_CARAV")
    */
    public function updateHeuresAction(Depart $depart, Request $req)
    {
        
        if($req->getMethod()=="POST")
        {
        $departUpdated=$depart;
        $form=$this->createForm(new DepartType(),$departUpdated);
        $form->bind($req);
        $em=$this->em();
        $em->persist($departUpdated);
        /*foreach($departUpdated->getHeuresDepart()->getIterator() as $i=>$object )
        {
        $em->persist($departUpdated->getHeuresDepart()[$i]);
        }*/
        $em->flush();
        return $this->sendResponse(array('msg'=>"Modifications enregistrées"));
        } else {
            $form= $this->createForm(new DepartType(),$depart);
          return $this->render('GOCaravaneBundle:Depart:_depart_heures.html.twig', array('form'=>$form->createView(), 'depart'=>$depart));
      }
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("details_depart-{id}.golob", name="details_depart")
    */
    public function getDetailsAction(Depart $depart, Request $req)
    {
        
        $resRepo=$this->getRepo('Reservation');
        $totaux=$resRepo->getNombreInscritPointsDep($depart);
        $nombre_online=$resRepo->getNombreInscritDepartOnline($depart);
        //var_dump($totaux);die();
          return $this->render('GOCaravaneBundle:Depart:details_depart.html.twig', array('totaux'=>$totaux, 'nombre_online'=>$nombre_online));
      
        
    }
 
    /**
     * @param Request $req
     * @return type
     * @Route("bilan_depart-{id}.golob", name="bilan_depart")
    */
    public function bilanDepartIndexAction(Depart $depart, Request $req)
    {
        $bilanDepart=new BilanDepart();
        $bilanDepart->setDepart($depart);
        $bilanDepart->setNombreInscrit($this->getRepo('Reservation')->getNombreInscritDepart($depart));
        $form= $this->createForm(new BilanDepartType($depart),$bilanDepart);
        
        return $this->render('GOCaravaneBundle:Depart:bilan_depart_index.html.twig',array('depart'=>$depart,'form'=>$form->createView()));
      
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("bilan_depart_process-{id}.golob", name="bilan_depart_process")
    */
    public function bilanDepartProcessAction(Depart $depart, Request $req)
    {
        $bilanDepart=new BilanDepart();
        $bilanDepart->setDepart($depart);
        $form= $this->createForm(new BilanDepartType($depart),$bilanDepart);
        $bilanDepart->setSavedAt(new \DateTime());
        $bilanDepart->setLastUpdate(new \DateTime());
        $bilanDepart->setUser($this->getUser());
        $form->bind($req);
        foreach($bilanDepart->getDepenses()->getIterator() as $ind=>$depense)
        {
            $bilanDepart->getDepenses()[$ind]->setBilanDepart($bilanDepart)->setUser($this->getUser());
        }
        $em= $this->em();
        $em->persist($bilanDepart);
        $em->flush();
       return $this->render('GOCaravaneBundle:Depart:bilan_depart_show.html.twig',array('bilan'=>$bilanDepart));

        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("bilan_depart_update-{id}.golob", name="bilan_depart_update")
    */
    public function bilanDepartUpdateAction(Depart $depart, Request $req)
    {
        //$bilanDepart=new BilanDepart();
        if($req->getMethod()=="POST")
        {
            $bilanDepart=$depart->getBilan();
        
        $form=$this->createForm(new BilanDepartType($depart),$bilanDepart);
        $form->bind($req);
        foreach($bilanDepart->getDepenses()->getIterator() as $ind=>$depense)
        {
            if(is_null($depense->getBilanDepart()))
            $bilanDepart->getDepenses()[$ind]->setBilanDepart($bilanDepart)->setUser($this->getUser());
        }
        $em=$this->em();
        $em->persist($bilanDepart);
       $em->flush();
        return $this->sendResponse(array('view'=>'GOCaravaneBundle:Depart:bilan_depart_show.html.twig','responseVars'=>array("bilan"=>$depart->getBilan()),'msg'=>"Modifications enregistrées"));
        } 
        $form= $this->createForm(new BilanDepartType($depart),$depart->getBilan());
        return $this->render('GOCaravaneBundle:Depart:bilan_depart_update.html.twig',array('form'=>$form->createView(),'depart'=>$depart));
      
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("bilan_depart_show-{id}.golob", name="bilan_depart_show")
    */
    public function bilanDepartShowAction(Depart $depart, Request $req)
    {
        
       return $this->render('GOCaravaneBundle:Depart:bilan_depart_show.html.twig',array('bilan'=>$depart->getBilan()));
      
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("depense_depart_delete-{id}.golob", name="depense_depart_delete")
    */
    public function deleteDepenseDepartAction(DepenseDepart $depenseDepart, Request $req)
    {
        $bilan=$depenseDepart->getBilanDepart();
        $em=$this->em();
        $em->remove($depenseDepart);
        $em->flush();
        
       return $this->render('GOCaravaneBundle:Depart:bilan_depart_show.html.twig',array('bilan'=>$bilan));
      
        
    }
    /**
     * @param Request $req
     * @return type
     * @Route("bilans/show/all", name="bilan_des_departs")
     * @Secure(roles="ROLE_SUPER_ADMIN")
    */
    public function bilansDepartAction(Request $req)
    {
        //$departs=$this->getRepo('Depart')->getListeDeparts(Cons::DEPART_NON_PASSE)->getQuery()->getResult();
        $departs= $liste=$this->getRepo('Depart')->getListeDeparts(Cons::DEPART_PASSE)->orderBy('d.date','DESC')->getQuery()->getResult();
      
        if($req->isXmlHttpRequest())
       return $this->render('GOCaravaneBundle:Depart:liste_depart_bilan.html.twig', array('liste'=>$departs));
       else
      return $this->render('GOCaravaneBundle:Depart:show_all.html.twig',array('liste'=>$departs));
      
        
       
    }
    /**
     * 
     * @param Evenement $event
     * @Route("departs/event/{id}", name="all_departs_event")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function getDepartsEventAction(Evenement $event)
    {
        $departRepo=$this->getRepo('Depart');
        $departs=$departRepo->getDepartsEvent($event);
        return $this->render('GOCaravaneBundle:Depart:liste_depart_bilan.html.twig', array('liste'=>$departs));
     
    }
}
