<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use GO\ClientBundle\Entity\CompteClient;
use GO\ShopBundle\Utils\Constants as Cons;
/**
 * Description of ClientController
 *
 * @author LBC
 */
class ClientController extends MainController {
    //put your code here
    /**
     * 
     * @param Request $req
     * @Route("/client/index", name="shop_client_index")
     */
    public function indexAction(Request $req) {
        return $this->render('@GOShop/Client/main_layout.html.twig');
    }
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Créer Client", "id"=>"", "href"=> $this->generateUrl("client_new")),
           array("libelle"=>"Créer Compte Client", "id"=>"", "href"=> $this->generateUrl("compte_client_new")),
             array("libelle"=>"Classement du Mois", "id"=>"", "href"=>$this->generateUrl("shop_classement_compte_clients", ["nombre"=>30]), 
               ),
            array("libelle"=>"Rechercher Compte", "href"=> $this->generateUrl("compte_client_search")),
            array("libelle"=>"Afficher", "id"=>"",
               "dropdown"=>array(
                                array("libelle"=>"Les Comptes Clients", "id"=>"", "href"=> $this->generateUrl("compte_client_index")),
                                array("libelle"=>"Promotions", "id"=>"", "href"=> $this->generateUrl("code_bar_search")),
                                
                   )),
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }

    /**
     * 
     * @param Request $req
     * @param type $number
     * @Route("/compte_client/{id}/get_historique", name="shop_historique_compte_client")
     */
    public function getHistoriqueCompte(Request $req,CompteClient $compte=null)
    {
        $venteRepo=$this->getRepo('Vente');
        $totaux=[
            "totalVente"=>$venteRepo->getTotalVentesCompteClient($this->getShop(),$compte, Cons::VENTE_TOTAL_VENTE),
            "totalBenefice"=>$venteRepo->getTotalVentesCompteClient($this->getShop(),$compte, Cons::VENTE_TOTAL_BENEFICE),
            "totalNombreVente"=>$venteRepo->getTotalVentesCompteClient($this->getShop(),$compte, Cons::VENTE_NOMBRE_VENTE),
            ];
        $params=[
            "compte"=>$compte,
                "ventes"=> $venteRepo->getVentesCompteClient($this->getShop(),$compte),
                "totaux"=>$totaux];
        
        return $this->render('@GOShop/Client/historique_compte.html.twig',$params);
        
    }
    /**
     * 
     * @param Request $req
     * @param type $number
     * @Route("/compte_client/classement/nombre/{nombre}", name="shop_classement_compte_clients")
     */
    public function getStandings(Request $req,$nombre)
    {
        $date_debut=null;
        $date_fin=null;
      $qb= $this->getRepo('Vente');
        $qb= $qb->createQueryBuilder('v')
        ->addSelect('SUM(v.quantite*v.prixUnit) as totalAchete')
        ->addSelect('SUM(v.benefice) as totalBenefice')
        ->addSelect('COUNT(v.id) as nombreAchete')
        ->addSelect('SUM(v.quantite) as quantiteAchete')
        ->groupBy('v.compteClient')
        ->orderBy('totalAchete', 'DESC')
        ->setMaxResults($nombre)
       ->where('v.shop=:shop')
       ->andWhere('v.compteClient IS NOT NULL')
        ->setParameter('shop', $this->getShop());
         if(!is_null($date_debut))
                {
                    $qb->andWhere('DATE(v.date)>=:date_debut');
                    $qb->setParameter('date_debut', $date_debut);
                   
                    if(!is_null($date_fin))
                    {
                        $qb->andWhere('DATE(v.date)<=:date_fin');
                        $qb->setParameter('date_fin', $date_fin);
                    }
                }
        $results= $qb->getQuery()->getResult();
                
   //dump($results);die();
        //echo count($results);die();
        return $this->render('@GOShop/Client/classement.html.twig',['classements'=>$results]);
        
    }
}
