<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\MainBundle\Entity\Client;
use GO\ShopBundle\Utils\ShopSummary;
use GO\ShopBundle\Utils\ShopReportMois;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\Vente;
use GO\ShopBundle\Entity\Charge;
use GO\ShopBundle\Entity\FactureAbstract;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Controller\MainController;
use GO\MainBundle\Form\ClientType;
use GO\MainBundle\Form\ClientDetailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Description of ClientController
 *
 * @author hp
 *@Route("/admin/")
 */

class ShopAdminController extends MainController {
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
        * @Route("today_summary.golob", name="show_summary_today")
        * @Route("api/summary/today", name="api_show_summary_today")
        * @Secure(roles="ROLE_ADMIN")
        */ 
        public function getDailyPreview(Request $req)
        {
            $venteRepo=$this->getRepo("Vente");
            $venteServiceRepo=$this->getRepo("VenteService");
            $daily_totals=array();
            $shops=$this->getRepo('Shop')->findAll();
            $date_debut="2018-05-04";
            $date_fin="2018-05-04";
            $condition=Cons::AUJOURDHUI;
            foreach ($shops as $shop)
            {
            $totals=array();
            $totals['shop']= $shop->getLibelle();
            $totals['vente']= $venteRepo->getTotalVente($shop,$condition,null,$date_debut,$date_fin);
            $totals['venteService']= $venteServiceRepo->getTotalVente($shop,Cons::AUJOURDHUI);
            $totals['benefice']= $venteRepo->getTotalBenefice($shop,Cons::AUJOURDHUI);
            $totals['venteMois']= $venteRepo->getTotalVente($shop,Cons::MOIS);
            $totals['venteServiceMois']= $venteServiceRepo->getTotalVente($shop,Cons::MOIS);
            $totals['beneficeMois']= $venteRepo->getTotalBenefice($shop,Cons::MOIS);
            $totals['achat']=$this->getRepo('Achat')->getTotalAchat($shop,Cons::AUJOURDHUI, \GO\ShopBundle\Entity\AchatRepository::ACHAT_PAYE);
            $totals['depense']=$this->getRepo('Sortie')->getTotalCharge($shop, \GO\ShopBundle\Entity\ChargeRepository::CHARGE_FIXE,Cons::AUJOURDHUI);
            $totals['dette']=$this->getRepo('FactureAchat')->getTotalFacture($shop,Cons::AUJOURDHUI, \GO\ShopBundle\Entity\FactureAbstract::FACTURE_NON_PAYE);
            $totals['creance']=$this->getRepo('FactureVente')->getTotalFacture($shop,Cons::AUJOURDHUI, \GO\ShopBundle\Entity\FactureAbstract::FACTURE_NON_PAYE);
            $totals['shopDetails']= $shop;
            $totals['produits_vendus']=$venteRepo->getListeVente($shop,$condition,null,$date_debut,$date_fin);
            $totals['factures_achat_today']=$this->getRepo('FactureAchat')->getListeFactures($shop,Cons::AUJOURDHUI);
            $totals['depenses_effectues']=$this->getRepo('Sortie')->getListeSortie($shop,Cons::DATE_INTERVALLE,$date_debut=Date('Y-m-d'),Date('Y-m-d'));
           array_push($daily_totals, $totals);
            }
            return $this->render('@GOShop/Admin/today_summary.html.twig', array('daily_totals'=>$daily_totals));
        }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("month_summary/{mois}/{annee}", name="admin_shop_month_summary",requirements={"mois"="\d+", "annee"="\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getMonthSummaryAction(Request $req)
    {
        $mois= $req->get('mois');
        $annee= $req->get('annee');
        $dateDebutMois=$annee."-".$mois."-01";
        $dateFinMois=$annee.'-'.$mois.'-'.cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
        //var_dump($dateDebutMois,$dateFinMois);die();
       
        $shopReports=array();
        $shops= $this->getRepo('Shop')->findAll();
        foreach ($shops as $shop)
        {
         $shopReport=new ShopReportMois();
        $shopReport->setShop($shop);
        $shopReport->setDetteLiquideMois($this->getRepo('DetteLiquide')->getTotalDetteNonRemb($shop,$dateDebutMois));//function to create
        $shopReport->setDetteFactureMois($this->getRepo('FactureAchat')->getTotalFacture($shop,Cons::DATE_INTERVALLE, FactureAbstract::FACTURE_NON_PAYE,$dateDebutMois,$dateFinMois));
        $shopReport->setCreanceProduitMois($this->getRepo('FactureVente')->getTotalFacture($shop,Cons::DATE_INTERVALLE,FactureAbstract::FACTURE_NON_PAYE,$dateDebutMois,$dateFinMois));
        //$shopReport->setValeurStock($this->getRepo('Stock')->getValeurStock($shop));//function to create
        $shopReport->setVenteMois($this->getRepo('Vente')->getTotalVente($shop,Cons::DATE_INTERVALLE,'',$dateDebutMois,$dateFinMois));//function to create
        $shopReport->setAchatMoisPaye($this->getRepo('FactureAchat')->getTotalFacture($shop,Cons::DATE_INTERVALLE,FactureAbstract::FACTURE_PAYE,$dateDebutMois,$dateFinMois));//function to create
        $shopReport->setBeneficeMois($this->getRepo('Vente')->getTotalBenefice($shop,Cons::DATE_INTERVALLE,'',$dateDebutMois,$dateFinMois));//function to create
        $shopReport->setDepenseMois(($this->getRepo('Sortie')->getTotalCharge($shop,Charge::CHARGE_APPOVRISSANTE,Cons::DATE_INTERVALLE,$dateDebutMois,$dateFinMois)));//function to create
       
        array_push($shopReports, $shopReport);
        }
        return $this->render('@GOShop/Admin/month_summary.html.twig', array('shops'=>$shopReports));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("exercice_summary", name="admin_exercice_summary")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function getExerciceSummaryAction(Request $req)
    {
        $exercice= $this->getRepo('Exercice')->getCurrent();
        $dateDebutExercice=$exercice->getDateStart()->format('Y-m-d');
        $dateFin=$exercice->getDateEnd()->format('Y-m-d');
        
        $shopSummaries=array();
        
        $shops= $this->getRepo('Shop')->findAll();
      
        foreach($shops as $shop)
        {
        
        $ShopSummary=new ShopSummary();
        $ShopSummary->setShop($shop);
        $ShopSummary->setCapitalExercice($this->getRepo('Capital')->findOneByShop($shop)->getMontant());
         $ShopSummary->setTotalDetteFacture($this->getRepo('FactureAchat')->getTotalFacture($shop,Cons::DATE_INTERVALLE, \GO\ShopBundle\Entity\FactureAbstract::FACTURE_NON_PAYE,$dateDebutExercice,$dateFin));
        $ShopSummary->setTotalCreanceProduitExercice($this->getRepo('FactureVente')->getTotalFacture($shop,Cons::DATE_INTERVALLE, \GO\ShopBundle\Entity\FactureAbstract::FACTURE_NON_PAYE,$dateDebutExercice,$dateFin));
        $ShopSummary->setValeurStock($this->getRepo('Stock')->getValeurStock($shop)+$this->getRepo('Achat')->getValeurStockCodeBar($shop));//function to create
       // $ShopSummary->setValeurStock($ShopSummary->getValeurStock());
        $ShopSummary->setTotalCreanceLiquide($this->getRepo('CreanceLiquide')->getTotalCreance($shop,["dateDebut"=>$dateDebutExercice,"dateFin"=>$dateFin]));
        $ShopSummary->setTotalVenteExercice($this->getRepo('Vente')->getTotalVente($shop,Cons::DATE_INTERVALLE,'',$dateDebutExercice,$dateFin));//function to create
        $ShopSummary->setTotalAchatExercice($this->getRepo('Achat')->getTotalAchat($shop,Cons::DATE_INTERVALLE, \GO\ShopBundle\Entity\AchatRepository::ACHAT_PAYE,$dateDebutExercice,$dateFin));//function to create
        $ShopSummary->setTotalBeneficeExercice($this->getRepo('Vente')->getTotalBenefice($shop,Cons::DATE_INTERVALLE,'',$dateDebutExercice,$dateFin));//function to create
        $ShopSummary->setTotalDepenseExercice(($this->getRepo('Sortie')->getTotalCharge($shop,Charge::CHARGE_APPOVRISSANTE,Cons::DATE_INTERVALLE,$dateDebutExercice,$dateFin)));//function to create
        $ShopSummary->setSoldeCaisse($this->getRepo('Caisse')->findOneByShop($shop)->getSolde());//function to create
        array_push($shopSummaries, $ShopSummary);
        
      
        
        //=== Récupérer les données des mois passés (vente, achats, bénéfices ventes, dettes, creances, charges)....
        $janv=1;$dec=12;
        $premierMois=array("annee"=>$exercice->getDateStart()->format('Y'),"mois"=>$exercice->getDateStart()->format('m'));
       $dernierMois=array("annee"=>Date('Y'),"mois"=>Date('m'));
       $moisDepart=$premierMois['mois'];
       $moisFin=$exercice->getDateEnd()->format('m');
       $anneeFinEx=$exercice->getDateEnd()->format('Y');
       $anneeDepart=$premierMois['annee'];
       $moisActuel=Date('m');
       $anneeActuel=Date('Y');
       $annee=$anneeDepart;
       $moisList=array();
       $nomsMois=array("Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre",'Novembre',"Décembre");
      $anneesToShow=array($anneeActuel,$anneeActuel-1);
      $moisToShow=array();
        $getData=function($mois,$annee) use($shop,$nomsMois, $moisList)
           {
             
         $shopReport=new ShopReportMois();
          
           $dateDebutMois=$annee."-".$mois."-01";
           $dateDebutFin=$annee."-".$mois."-".cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
           $shopReport->setMoisLibelle($nomsMois[intval($mois)-1].' '.$annee);
           $shopReport->setVenteMois($this->getRepo('Vente')->getTotalVente($shop,Cons::DATE_INTERVALLE,'',"$annee-$mois-01","$annee-$mois-".cal_days_in_month(CAL_GREGORIAN, $mois, $annee)));
           $shopReport->setBeneficeMois($this->getRepo('Vente')->getTotalBenefice($shop,Cons::DATE_INTERVALLE,'',"$annee-$mois-01","$annee-$mois-30"));
           $shopReport->setAchatMoisPaye($this->getRepo('Achat')->getTotalAchat($shop,Cons::DATE_INTERVALLE, \GO\ShopBundle\Entity\AchatRepository::ACHAT_PAYE,"$annee-$mois-01","$annee-$mois-".cal_days_in_month(CAL_GREGORIAN, $mois, $annee)));//function to create
           $shopReport->setDepenseMois(($this->getRepo('Sortie')->getTotalCharge($shop,Charge::CHARGE_FIXE,Cons::DATE_INTERVALLE,"$annee-$mois-01","$annee-$mois-".cal_days_in_month(CAL_GREGORIAN, $mois, $annee))
                   +($this->getRepo('Sortie')->getTotalCharge($shop,Charge::CHARGE_VARIABLE,Cons::DATE_INTERVALLE,"$annee-$mois-01","$annee-$mois-".cal_days_in_month(CAL_GREGORIAN, $mois, $annee)))));//function to create
       
           // ajouter l'objet shopReport dans le tableau des mois du rapport
         //array_push($moisList, $shopReport);
         //return $moisList;
         return $shopReport;
           };
       //  permet de savoir si on est dans la même année que le debut de l'exercicce
      // if($anneeDepart==$anneeActuel)
       
        
       if(intval($anneeFinEx==$anneeDepart))
       {
        for($i=intval($moisDepart);$i<=$dec;$i++)
        { $mois=$i;
           if(strlen($i)==1){
           $mois="0".$i;
           }array_push($moisToShow,array($mois,$annee));
           
        } 
       }
       elseif(intval(($anneeFinEx-$anneeDepart))===1)
       {   
        for($i=intval($moisDepart);$i<=$dec;$i++)
        { $mois=$i;
           if(strlen($i)==1){
           $mois="0".$i;
           }array_push($moisToShow,array($mois,$annee));
           
        }
        $annee=$anneeActuel;
          for($i=1;$i<=intval($moisFin);$i++)
          {$mois=$i;
           if(strlen($i)==1){
           $mois="0".$i;
           }
           array_push($moisToShow,array(intval($mois),$annee));
              
          }
       }
       foreach($moisToShow as $element)
       {
           //var_dump($elemet,"///<br>");
           array_push($moisList, $getData($element[0], $element[1]));
       }
       
       
        $ShopSummary->setMonthlyReports($moisList);
        }
        return $this->render('@GOShop/Admin/exercice_summary.html.twig', 
                            array('shops'=>$shopSummaries,
                                ));
    }
}
