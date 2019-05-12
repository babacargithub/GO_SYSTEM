<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use GO\CaravaneBundle\Utils\Constants as Cons;

use GO\MainBundle\Utils\SMSSender;

class PointDepartController extends MainController {
    //put your code here
    public function menuVerticalAction()
    {
        
    }
    public function heuresDepartFlashAction()
    {
        $points_dep=$this->getRepo('PointDepart')->getListePointDeparts(Cons::UGB_DAKAR)->getQuery()->getResult();
        $heures_nuit="";
        foreach($points_dep as $point_dep)
        {
            if($point_dep->getNom()!="inconnu")
            $heures_nuit.=$point_dep->getNom()."->".$point_dep->getHeurePointDep()->format("H\h:i")."// ";
        }
       $heures_soir="";
       foreach($points_dep as $point_dep)
        {
            if($point_dep->getNom()!="inconnu")
            $heures_soir.=$point_dep->getNom()."->".$point_dep->getHeurePointDepSoir()->format("H\h:i")."// ";
        }
        
        return $this->render('GOCaravaneBundle:PointDepart:heures_flash.html.twig', array("heures_nuit"=>$heures_nuit, "heures_soir"=>$heures_soir));
    }
    public function indexAction(Request $req)
    {
        
    }
    public function rapprocherHeuresAction(Request $req)
    {
        $minute=$req('minute');
        $heure=$req('heure');
        
    }
    public function repousserHeuresAction(Request $req)
    {
        
    }
    public function addAction()
    {}
    public function updateAction()
    {
        
    }
    
}
