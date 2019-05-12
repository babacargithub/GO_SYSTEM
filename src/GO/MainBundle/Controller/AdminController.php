<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Client;
use GO\MainBundle\Utils\ShopSummary;
use GO\ShopBundle\Entity\Shop;
use GO\CaravaneBundle\Entity\Reservation;
use GO\CaravaneBundle\Controller\MainController;
use GO\MainBundle\Form\ClientType;
use GO\MainBundle\Form\ClientDetailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Description of ClientController
 *
 * @author hp
 *@Route("/admin/")
 */

class AdminController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
        $user=$this->getUser();
         $liste = array(array("libelle"=>"Rapport Shops", "href"=>$this->generateUrl("show_summary_today")),
             array("libelle"=>"Rapports Caravane","href"=>"client_recherche.golob"),
             array("libelle"=>"Rapports SMS","href"=>"client_export_all.golob"),
             array("libelle"=>"Rapports Activités","href"=>"client_export_all.golob"),
             );
        return $this->render('GOMainBundle:Admin:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("index/", name="admin_index")
     */
    public function indexAction(Request $req)
    {
        return $this->render('GOMainBundle:Admin:layout.html.twig');
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("shop/summary/{id}", name="admin_shop_summary")
     */
    public function getShopSummaryAction(Shop $shop, Request $req)
    {
        $donnees=new ShopSummary();
        $donnees->setCapitalExercice();
        $donnees->setTotalDetteLiquide();//function to create
        $donnees->setTotalDetteFacture();//function to create
        $donnees->setTotalCreanceLiquide();//function to create
        $donnees->setTotalCreanceProduit();//function to create
        $donnees->setValeurStock();
        $donnees->setTotalVenteExercice();//function to create
        $donnees->setTotalVenteMois();
        $donnees->setTotalVenteMoisPasseExercice();//function to create
        $donnees->setTotalVenteJour();
        $donnees->setTotalAchatExercice();//function to create
        $donnees->setTotalAchatMois();
        $donnees->setTotalAchatMoisPasseExercice();//function to create
        $donnees->setTotalAchatJour();
        $donnees->setTotalCreanceLiquideExercice();//function to create
        $donnees->setTotalCreanceLiquideMois();
        $donnees->setTotalCreanceLiquideMoisPasseExercice();//function to create
        $donnees->setTotalCreanceLiquideJour();
        $donnees->setTotalCreanceProduitExercice();//function to create
        $donnees->setTotalCreanceProduitMois();
        $donnees->setTotalCreanceProduitMoisPasseExercice();//function to create
        $donnees->setTotalCreanceProduitJour();
        $donnees->setTotalBeneficeExercice();//function to create
        $donnees->setTotalBeneficeMoisPasseExercice();//function to create
        $donnees->setTotalBeneficeMois();
        $donnees->setTotalBeneficeJour();
        $donnees->setSoldeCaisse();
        $donnees->setSoldeBanque();//function to create
        $donnees->setPourcentageOJV();//function to create
        $donnees->setVenteJourExercicePrecedent();//function to create
        $donnees->setVenteMoisExercicePrecedent();//function to create
        $donnees->setNombreArticleVenduJour();
        $donnees->setNombreArticleVenduMois();
        $donnees->setNombreCompteOuvertMois();//function to create
        $donnees->setNombreCompteOuvertJour();//function to create
        $donnees->setTotalVenteTypeProduit();//function to create
        $donnees->setTotalBeneficeTypeProduit();//function to create
        $donnees->setNombreArticleVenduTypeProduit();//function to create
        return $this->render('GOMainBundle:Admin:Shop:shop_summary.html.twig', array('shopSummary'=>$donnees));
    }
}
