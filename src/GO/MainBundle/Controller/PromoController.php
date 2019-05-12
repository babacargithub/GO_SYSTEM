<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;
use GO\MainBundle\Form\PromoType;
use GO\MainBundle\Form\RemiseCarteType;
use GO\MainBundle\Entity\Promo;
use GO\MainBundle\Entity\RemiseCarte;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PromoController
 *
 * @author hp
 */
class PromoController extends \GO\CaravaneBundle\Controller\MainController{
    //put your code here
    public function indexAction(Request $req){
        $form= $this->createForm(new PromoType(),new Promo());
        $remise=new RemiseCarte;
        $form_remise= $this->createForm(new RemiseCarteType(),$remise);
        
        return $this->render('GOMainBundle:Promo:index.html.twig', 
                array('form'=>$form->createView(), 'form_remise'=>$form_remise->createView()));
    }
    public function menuVerticalAction(Request $req)
    {
        $user=$this->getUser();
         $liste = array(array("libelle"=>"Nouvelle Promo", "href"=>"c_kheweul.golob"),
             array("libelle"=>"Nouvelle Remise Carte","href"=>"search_index_c_kheweul.golob"),
             array("libelle"=>"Liste Cartes","href"=>"show_c_kheweul.golob"));
         if($user->hasRole('ROLE_ADMIN'))
         {
             array_push($liste, array("libelle"=>"Promo","href"=>"promo_index.golob"));
         }
        return $this->render('GOMainBundle:CarteKheweul:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    public function addAction(Request $req)
    {
        $promo=new Promo();
        $form= $this->createForm(new PromoType(), $promo);
        $form->bind($req);
        if($form->isValid())
        {
           if($promo->isPasse())
           {
               return new Response('La date de fin de la promo est déja pssée!');
           }else
           {
            $em= $this->em();
            $em->persist($promo);
            $em->flush();
           }
            
        }else
        {
            return $this->render('GOMainBundle:Promo:index.html.twig', array('form'=>$form->createView()));
        }
        
    }
    public function addRemiseAction(Request $req)
    {
        $remiseRepo= $this->getRepo('RemiseCarte');
        $remise=new RemiseCarte;
        $form= $this->createForm(new RemiseCarteType(),$remise);
        $form->bind($req);
        if($form->isValid())
        {
            if($remiseRepo->hasPromo($form->getData()->getCarte()->getId(), $form->getData()->getPromo()->getId()))
            { 
                return new Response('La carte bénéfie déjà d\'une réduction sur la promo sélectionné');
            }
            else
            {
                if($remise->isPasse())
                {
                    return Response('La Date de fin de la remise est passé');
                }else
                {$em= $this->em();
                    $em->persist($remise);
                    $em->flush();
                    return new Response('Remise appliqué avec succès!');
                }
            }
        }else
        {
             return $this->render('GOMainBundle:Promo:index.html.twig', 
                array( 'form_remise'=>$form->createView()));
    
        }
    }
}
