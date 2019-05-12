<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;
//use GO\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Form\TransfertProduitType;
use GO\ShopBundle\Form\ProduitTransfereType;
use GO\ShopBundle\Entity\Produit;
use GO\ShopBundle\Entity\Stock;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\TransfertProduit;
use GO\ShopBundle\Entity\ReceptionTransfertProduit;
use GO\ShopBundle\Entity\ProduitTransfere;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
/**
 * Description of VenteController
 *
 * @author hp
 */
class TransfertProduitController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Ajouter", "id"=>"", "href"=>"produit.golob"),
            array("libelle"=>"Recherche", "id"=>"", "href"=>"produit_search_index.golob"),
           array("libelle"=>"Catégorie", "id"=>"", "href"=>"#", 
                 "dropdown"=>array(
                                array("libelle"=>"Ajouter une Catégorie", "id"=>"", "href"=>"produit_cat_index.golob"),
                                array("libelle"=>"Liste des Catégories", "id"=>"", "href"=>"produit_cat_show.golob"),
                          )
               
               ),
           array("libelle"=>"Top 10 Ventes", "id"=>"", "href"=>"produit_top10.golob"),
           array("libelle"=>"Stock", "id"=>"",
               "dropdown"=>array(
                                array("libelle"=>"Etat Stock", "id"=>"", "href"=>"stock_index.golob"),
                                array("libelle"=>"Stock des produits", "id"=>"", "href"=>"stock_produits_show.golob"),
                                array("libelle"=>"Nouvel Inventaire", "id"=>"", "href"=>"stock_produits_show.golob"),
                                array("libelle"=>"Liste des inventaires", "id"=>"", "href"=>"stock_produits_show.golob"),
                                array("libelle"=>"Transferts Produit", "id"=>"", "href"=>"transfert_produit_index.golob"),
                          )),
           );
        return $this->render('GOShopBundle::menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("transfert_produit_index.golob", name="transfert_produit_index")
     */
    public function formAction(Request $req)
    {
       $TransfertProduit= new TransfertProduit();
        
        $form= $this->createForm(new TransfertProduitType($this->get('session')), $TransfertProduit);
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_transfert_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Produit:_transfert_form.html.twig', array("form"=>$form->createView()));
     
        
        
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("transfert_produit_new.golob",name="go_shop_transfert_produit_add")
     */
    public function addAction(Request $req)
    {
         $msg=null;
        $errorMsg=null;
       $request=$req;
         $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
        $TransfertProduit= new TransfertProduit();
        $ProduitForm= $this->createForm(new TransfertProduitType($this->get('session')),$TransfertProduit);
       $ProduitForm->bind($req);
         $TransfertProduit->setDate(new \DateTime())
                 ->setShop($this->getShop())
                 ->setUser($this->getUser())
                 ->setValidated(false);
        //=== vérifier si le formulaire est valide
         if($ProduitForm->isValid())
        {
            
             $em= $this->em();
              $em->persist($TransfertProduit);
              //==========Parcours la liste des achats attachés à l'objet facture et les attaches à la facture pour la persistance
        foreach($TransfertProduit->getProduitTransferes()->getIterator() as $i=>$object)
        {
        $TransfertProduit->getProduitTransferes()[$i]->setTransfertProduit($TransfertProduit);
       // $TransfertProduit->getProduitTransferes()[$i]->setPaye($facture_paye);
        $em->persist($TransfertProduit->getProduitTransferes()[$i]);
        }
        $Reception =new ReceptionTransfertProduit();
        $Reception->setTransfertProduit($TransfertProduit);
        $Reception->setValidated(false);
        $Reception->setDate(new \DateTime());
        $em->persist($Reception);
              $em->flush();
                    
                    $msg="Transfert Produit enregistrée avec succès!";
             
            
        }else
            {
                //var_dump($ProduitForm); die();
            return $this->sendResponse(array('view'=>'GOShopBundle:Produit:index.html.twig'
                ,"responseVars"=>array(
                    'form'=>$ProduitForm->createView()),
                   "msg"=>$msg,
                 "errorMsg"=>"Formulaire invalide! Les données saisies ne sont pas correcte!"
                   //"responseVars"=> array('form'=>$resForm->createView()
                    ));

            }
        return $this->sendResponse(array(
               "view"=>'GOShopBundle:Produit:index.html.twig',
                "responseVars"=>array(),
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
        
        }
        
    public function deleteAction(Produit $produit, Request $req)
        {
        $msg=null;
        $errorMsg=null;
             $em=$this->em();
                $em->remove($produit);
                try {
                   $em->flush();
                   $msg="Produit supprimé avec succès!";
                   
                } catch (Exception $ex) {
                    $this->setErrorMessage($ex->getMessage());
                    return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
              "errorMsg"=> $this->errorMsg));
                    
                }
                
                 return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=> $msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
            
        }
  
      
     
      
      
}
