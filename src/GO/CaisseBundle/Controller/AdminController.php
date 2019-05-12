<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaisseBundle\Controller;
use GO\CaisseBundle\Entity\Caisse;
use GO\CaisseBundle\Entity\Shop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Shop controller.
 *
 * @Route("admin")
 */
class AdminController extends MainController{
    // cette methode est exécuter quand l'utilisateur choisit une application, elle se chargera de vérifier s'il a accès
    // à l'application choisi ou nom
       public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Rapport Journée", "id"=>"", "href"=> $this->generateUrl("histo_today")),
           array("libelle"=>"Rapport Mensuel", "id"=>"", "href"=>$this->generateUrl("histo_today")),
           array("libelle"=>"Créer  Caisse", "id"=>"", "href"=>$this->generateUrl("caisse_pro_new")),
           array("libelle"=>"Ajouter Caissier", "id"=>"", "href"=>$this->generateUrl("caissier_new")),
           array("libelle"=>"Créer Boutique", "id"=>"", "href"=>$this->generateUrl("boutique_new")),
           array("libelle"=>"Donner Accès Caisse", "id"=>"", "href"=>$this->generateUrl("caisse_user_new")),
           array("libelle"=>"Donner Accès Boutique", "id"=>"", "href"=>$this->generateUrl("shop_user_new")),
           array("libelle"=>"Gérer Accès Boutique", "id"=>"", "href"=>$this->generateUrl("shop_user_index")),
           array("libelle"=>"Gérer Accès Caisse", "id"=>"", "href"=>$this->generateUrl("caisse_user_index")),
            array("libelle"=>"Plus", "id"=>"", "href"=>"#", 
            "dropdown"=>array(
                array("href"=>$this->generateUrl("fos_user_registration_register"), "libelle"=>"Créer Compte Utilisateur"),
                array("href"=>$this->generateUrl("compte_banque_new"), "libelle"=>"Créer Compte Banque"),
                                )
                ),
            );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("/index", name="caisse_pro_admin_index")
     */
    public function indexAction(Request $req) {
        return $this->render("@GOCaisse/admin/index.html.twig");
    }
}
