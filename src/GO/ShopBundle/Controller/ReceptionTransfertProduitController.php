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
class ReceptionTransfertProduitController extends MainController {
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
     * @Route("show_pending_reception.golob", name="pendig_reception")
     */
    public function showPendingAction(Request $req)
    {
        $pendings= $this->getRepo('ReceptionTransfertProduit')->getPendingReception($this->getShop());
        return $this->render('GOShopBundle:Stock:pending_reception.html.twig', array('pendings'=>$pendings));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("show_produit_reception-{id}.golob", name="show_produit_reception")
     */
    public function showProduitTransferes(ReceptionTransfertProduit $Reception, Request $req)
    {
        return $this->render('GOShopBundle:Stock:show_reception_produits.html.twig', array('produit_transferes'=>$Reception->getTransfertProduit()->getProduitTransferes()));
    }

    /**
     * 
     * @param Request $req
     * @return type
     * @Route("validate_reception_transfert_produit-{id}.golob",name="go_shop_valider_reception")
     */
    public function validateAction(ReceptionTransfertProduit $Reception, Request $req)
    {
        
       $stockRepo= $this->getRepo('Stock');
       $ShopReceiver=$Reception->getTransfertProduit()->getDestinataire();
       $ShopSender=$Reception->getTransfertProduit()->getShop();
        $Reception->setValidated(true);
        $Reception->setValidatedBy($this->getUser());
        $Reception->setDateOfValidation(new \DateTime());
       
        $em= $this->em();
        //==========Parcours la liste des produits attachés à l'objet TransfertProduit et modifie les stocks dans les 2 boutiques respectives
        $ProduitsTransferes=$Reception->getTransfertProduit()->getProduitTransferes();
        foreach($ProduitsTransferes->getIterator() as $i=>$object)
        {
        $quantite=$ProduitsTransferes[$i]->getQuantite();
        $produit=$ProduitsTransferes[$i]->getProduit();
        // récupération du stock du produit dans les deux boutiques concernées
        $stockShopReceiver=$stockRepo->findOneBy(array("shop"=>$ShopReceiver,"produit"=>$produit));
        $stockShopSender=$stockRepo->findOneBy(array("shop"=>$ShopSender,"produit"=>$produit));
        //augmentation du stock du produit pour la boutique qui va recevoir le transfert
        $stockShopReceiver->augmenter($quantite);
        //diminution du stock du produit pout la boutique qui a envoyé les produits
         $stockShopSender->diminuer($quantite);
         // persister les opérations de modification de Stock
                $em->persist($stockShopReceiver);
                $em->persist($stockShopSender);
        }
       $em->persist($Reception);
       try{
        $em->flush();
        $this->msg="Terminé!! Transfert validé avec succès!!";
         return $this->sendResponse(array(
               "view"=>'GOShopBundle:Produit:index.html.twig',
                "responseVars"=>array(),
               "msg"=>$this->msg,
               "errorMsg"=>$this->errorMsg
                ));
       } catch (Exception $ex) {
           $this->errorMsg="Une erreur technique s'est produite! ";
           $this->errorMsg.=$ex->getMessage();
           return $this->sendResponse(array(
               "view"=>'GOShopBundle:Produit:index.html.twig',
                "responseVars"=>array(),
               "msg"=> $this->msg,
               "errorMsg"=>$this->errorMsg
                ));
       }
        
          
        
        
        }
        
    public function deleteAction(Produit $produit, Request $req)
        {
        $msg=null;
        $errorMsg=null;
             $em=$this->em();
                $em->remove($produit);
                try {
                   $em->flush();
                   $msg="Réussi: Produit supprimé avec succès!";
                   
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
     public function showSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new ProduitSearchType(),$data);
         return $this->render('GOShopBundle:Produit:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    public function searchAction(Request $req)
    {
        
        $form=$this->createForm(new ProduitSearchType(), array());
        $form->bind($req);
        $shop= $this->getShop();
        $Produit=$this->getRepo('Produit');
        $venteRepo=$this->getRepo('Vente');
        $Stock= $this->getRepo('Stock');
        $data=$form->getData();
        if($form->isValid())
        {
            
        
        switch ($data['type_search'])
        {
            case 'total': $total_vente=$venteRepo->getTotalVente($shop,Cons::DATE_INTERVALLE,'', $data['debut'], $data['fin']);
                break;
            case 'type': $produits=$Produit->getListe()->getQuery()->getResult();
                return $this->render('GOShopBundle:Produit:liste.html.twig', 
                        array(
                            'produits'=>$produits));
                break;
            case 'nom_produit': 
                $produit=$Produit->findOneByNom($data['value']);
                $stock=null;
                if(!empty($produit))
                {
                $stock=$Stock->findOneBy(array('produit'=>$produit, "shop"=>$this->getShop()));
                }else
                {
                    return $this->render('GOShopBundle:Produit:details_produit.html.twig');
                        
                }
               //=============teste si l'intervalle de date est renseigné: date debut et date fin=====
                $date_debut=null;
                $date_fin=null;
                if(isset($data['date_debut'])&&$data['date_debut']!="")
                 $date_debut=$data['date_debut'];
                   if(isset($data['date_fin'])&&$data['date_fin']!="")
                        $date_fin=$data['date_fin'];
                //=========récuperation des données 
                   $ventes=$venteRepo->getHistoriqueVenteProduit($this->getShop(),$produit,$date_debut,$date_fin);
                $totaux=$venteRepo->getTotalProduit($this->getShop(),$produit,$date_debut,$date_fin);
               
              
                
                return $this->render('GOShopBundle:Produit:details_produit.html.twig', 
                        array(
                            'produit'=>$produit, 
                            "stock"=>$stock, 
                            "totaux"=>$totaux[0],
                            "ventes"=>$ventes));
            
        }
        
            }
        return $this->render('GOShopBundle:Vente:search_result.html.twig', array('ventes'=>$ventes, 'total_vente'=>$total_vente));
        
    }
    
    public function getDetailsAction(Request $req)
    {
        $produit= $this->getRepo('Produit')->findOneByNom($req->get('nom'));
        return $this->render('GOShopBundle:Produit:details_produit.html.twig', array('produit'=>$produit)); 
    }
    //=======================================Update functions 
    public function updateFormAction(Produit $Produit,Request $req)
    {
        //$Produit= new Produit();
        
        $form= $this->createForm(new ProduitEditType(), $Produit);
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_edit_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Produit:index.html.twig', array("form"=>$form->createView()));
     
      }
    public function updateAction(Request $req)
    {
        
        $produit=$this->getRepo('Produit')->find($req->get('go_shopbundle_produittype')['id']);
       $form= $this->createForm(new ProduitEditType(), $produit);
        $form->bind($req);
        if($form->isValid())
        {
        $em= $this->em();
        $em->persist($produit);
        $em->flush($produit);
        return new Response('Modification enregistrée avec succès!');
        }else
        {
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_edit_form.html.twig', array("form"=>$form->createView()));
        else
        return $this->render('GOShopBundle:Produit:index.html.twig', array("form"=>$form->createView()));
        }
      }
      
      
      public function getAllAction(Request $req)
      {
          return $this->render('GOShopBundle:Produit:liste_autocomplete.html.twig', array("produits"=> $this->getRepo('Produit')->findAll()));
      }
}
