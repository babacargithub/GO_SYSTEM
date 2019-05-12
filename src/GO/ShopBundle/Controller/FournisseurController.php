<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Form\FournisseurType;
use GO\ShopBundle\Entity\Fournisseur;
use GO\ShopBundle\Entity\FactureAbstract;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
class FournisseurController extends MainController {
    //put your code here
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("fournisseur_index.golob", name="fournisseur_index")
     */
    public function newAction(Request $req)
    {
        $fournisseur=new Fournisseur();
        $fourForm=$this->createForm(new FournisseurType(), $fournisseur);
        
        if($req->getMethod()=="POST")
        {
            $fourForm->bind($req);
            if($fourForm->isValid())
            {
            $em=$this->em();
            $em->persist($fournisseur);
            $em->flush();
            return new Response('Nouveau Fournisseur enregistré!');
            }
            
        } else {
            return $this->render('GOShopBundle:Fournisseur:index.html.twig', array('form'=>$fourForm->createView()));
            
        }
            
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("fournisseur_show.golob", name="fournisseur_show")
     */
    public function showListAction(Request $req)
    {
        $fournisseurs= $this->getRepo('Fournisseur')->findAll();
            return $this->render('GOShopBundle:Fournisseur:liste.html.twig', array('fournisseurs'=>$fournisseurs));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("fournisseur/show/{id}", name="show_fournisseur")
     */
    public function showAction(Fournisseur $fournisseur,Request $req)
    {
        //============ On récupère les données du fournisseur pour l'exercie en cours 
        $exercice= $this->getRepo('Exercice')->getCurrent();
        $dateDebut=$exercice->getDateStart()->format('Y-m-d');
        $dateFin=$exercice->getDateEnd()->format('Y-m-d');
        //on récupère les types de factures: fatcures payées et ou impayées 
        $facturesNonPayes= $this->getRepo('Fournisseur')->getListeFactures($this->getShop(),$fournisseur,Cons::DATE_INTERVALLE,FactureAbstract::FACTURE_NON_PAYE,$dateDebut,$dateFin);
        $facturesPayes= $this->getRepo('Fournisseur')->getListeFactures($this->getShop(),$fournisseur,Cons::DATE_INTERVALLE,FactureAbstract::FACTURE_PAYE,$dateDebut,$dateFin);
        return $this->render('@GOShop/Fournisseur/show.html.twig', array('fournisseur'=>$fournisseur, 
                                                                          'factures_non_payes'=>$facturesNonPayes,
                                                                          'factures_payes'=>$facturesPayes));
            
        
            
    }
}
