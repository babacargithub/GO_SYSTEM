<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Utils;
use Doctrine\ORM\EntityManager as EM;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Entity\Depart;
/**
 * Description of SeatNumberGenerator
 *
 * @author LBC
 */
class SeatNumberGenerator {
    //put your code here
    private $em;
    public function __construct(EM $em) {
        $this->em=$em;
    }
    public function generateSeat(Reservation $res)
    {
          $num= $this->em->getRepository('GOCaravaneBundle:Reservation')->getDernierNumPlace($res->getDepart());
          
               $num_place_vide=$this->em->getRepository('GOCaravaneBundle:Reservation')->getPremierePlaceVide($res->getDepart());
            if($num_place_vide==null)
            {
                        if($num<69)
                {
                $num=$num+1;
                $res->setNumPlace($num);
                }else
                        return "Erreur: toutes les places sont occupées pour le(s) bus du départ ".$res->getDepart()->getLibelle();
             }
             else{
                  $res->setNumPlace($num_place_vide);
                 }
                
                try
                {
                   // $this->em->persist($res);
                    //$this->em->flush();
                    
                     return $res;
                }catch(\Exception $e)
                {
                    echo $e->getMessage();
                    return false;
                }
    }
}
