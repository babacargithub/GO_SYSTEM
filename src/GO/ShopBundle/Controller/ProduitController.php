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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GO\ShopBundle\Form\ProduitType;
use GO\ShopBundle\Form\ProduitExportType;
use GO\ShopBundle\Form\CategorieType;
use GO\ShopBundle\Form\ProduitEditType;
use GO\ShopBundle\Form\ProduitSearchType;
use GO\ShopBundle\Entity\Produit;
use GO\ShopBundle\Entity\Stock;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\Categorie;
use GO\ShopBundle\Utils\Constants as Cons;
use JMS\Serializer\SerializationContext;

/**
 * Description of VenteController
 *
 * @author hp
 */
class ProduitController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Ajouter", "id"=>"", "href"=> $this->generateUrl("go_shop_produit_index")),
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
                                array("libelle"=>"Etat Stock", "id"=>"", "href"=> $this->generateUrl("stock_index")),
                                array("libelle"=>"Rechercher Stock", "id"=>"", "href"=> $this->generateUrl("code_bar_search")),
                                array("libelle"=>"Stock des produits", "id"=>"", "href"=> $this->generateUrl("stock_produits")),
                                array("libelle"=>"Nouvel Inventaire", "id"=>"", "href"=> $this->generateUrl("stock_inventaire_index")),
                                array("libelle"=>"Liste des Inventaires", "id"=>"", "href"=>$this->generateUrl("stock_inventaire_liste")),
                                array("libelle"=>"Transferts Produit", "id"=>"", "href"=>"transfert_produit_index.golob"),
                                array("libelle"=>"Réception Produits", "id"=>"", "href"=>"show_pending_reception.golob"),
                                
                   )),
           array("libelle"=>"Exporter", "id"=>"", "href"=>"produit_export_index.golob")
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    public function formAction(Request $req)
    {
       $Produit= new Produit();
        
        $form= $this->createForm(new ProduitType(), $Produit);
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Produit:index.html.twig', array("form"=>$form->createView()));
     
        
        
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("produit.golob", name="go_shop_produit_index")
    */
    public function addAction(Request $req)
    {
         $msg=null;
        $errorMsg=null;
       $request=$req;
         $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
        $Produit= new Produit();
        $ProduitForm= $this->createForm(new ProduitType(),$Produit);
       $ProduitForm->bind($req);
        $produitRepo= $this->getRepo('Produit');
        $produit=$produitRepo->findOneByNom($req->get('go_shopbundle_produittype')['nom']);
        if(empty($produit))
        {
         
        //=== vérifier si le formulaire est valide
         if($ProduitForm->isValid())
        {
            
             $em= $this->em();
              $em->persist($Produit);
              //===============Créer le stock pour le produit afin de le rendre disponible dans toutes les boutiques
              $shops= $this->getRepo('Shop')->findAll();
              foreach($shops as $shop)
              {
                  $Stock=new Stock();
                  $Stock->setShop($shop)->setProduit($Produit)->setQuantite(0);
                  $em->persist($Stock);
              }
              $em->flush();
              //générer un code Barre par défaut pour le nouveau produit crée 
                    $Produit->generateDefaultCodeBar();
                    $em->persist($Produit);
                    $em->flush();
                    $msg="Produit enregistrée avec succès!";
                    $ProuitController= $this->get('go_shop.static_data_generator');
                    $ProuitController->generateAucoCompleteProduitsFile();
        
             
            
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
        
        }else
        {
            $errorMsg="Le Produit ". $ProduitForm->getData()->getNom() ." existe déjà";
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
      
      //=====================LES FONCTIONS RELATIVES à LA GESTION DES CATEGORIES DE PRODUIT
      public function categFormAction(Request $req)
      {
          $Categorie= new Categorie();
        
        $form= $this->createForm(new CategorieType(), $Categorie);
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_cat_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Produit:index.html.twig', array("form"=>$form->createView()));
     
        
          
      }
      public function categUpdateFormAction(Request $req)
      {
          
      }
      public function categAddAction(Request $req)
      {
          $Categorie= new Categorie();
        
        $form= $this->createForm(new CategorieType(), $Categorie);
        $form->bind($req);
        if($form->isValid())
        {
            $em= $this->em();
            $em->persist($Categorie);
            $em->flush();
            return $this->sendResponse(array('msg'=>'Catégorie enregistré avec succès!'));
        }else
        {
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Produit:_cat_form.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Produit:index.html.twig', array("form"=>$form->createView()));
        }
          
      }
      public function categUpdateAction(Request $req)
      {
          
      }
      public function categShowAction(Request $req)
      {
          $catgories= $this->getRepo('Categorie')->findAll();
          return $this->render('GOShopBundle:Produit:cat_liste.html.twig', array("categories"=>$catgories));
          
      }
      /**
       * 
       * @param GO\ShopBundle\Entity\Categorie $cat
       * @param Request $req
       * @return type
       * @Route("categorie/{id}/show_produits", name="show_produits_categorie")
       */ 
      public function categShowProduitsAction(Categorie $cat, Request $req)
      {
          $produits= $this->getRepo('Produit')->findByCategorie($cat);
          return $this->render('GOShopBundle:Produit:liste.html.twig', array("produits"=>$produits));
          
      }
      public function categDeleteAction(Request $req)
      {
          
      }

      //====================AFFICHER LA LISTE DES 10 PRODUITS LES PLUS VENDUS DANS LE MOIS===============
      public function getTop10Action(Request $req)
      {
          $venteRepo=$this->getRepo("Vente");
          $ventes=$venteRepo->getTop10($this->getShop());
          return $this->render('GOShopBundle:Produit:top10.html.twig', array("ventes"=>$ventes));
      }    
      //==================Liste to show for pages requestinf  autocomplete=============//
       /**
     
     * @Route("produit_liste_autocomplete.golob ", name="liste_autocomplete", options = { "expose" = true })
     */
      public function getAllAction(Request $req)
      {
          return $this->render('GOShopBundle:Produit:liste_autocomplete.html.twig', array("produits"=> $this->getRepo('Produit')->findAll()));
      }
         /**
     
     * @Route("produit_export_index.golob ", name="produit_export_index")
     */
      public function exportIndexAction(Request $req)
      {
          $data = array();
                $form = $this->createForm(new ProduitExportType(),$data);
       
          return $this->render('GOShopBundle:Produit:export_index.html.twig', array('form'=>$form->createView()));
     
      }
         /**
     
     * @Route("produit_export_all.golob ", name="produit_export_all", options = { "expose" = true })
     */
      public function exportAction(Request $req)
    {
        /* Cette fonction permet d'exporter la liste des réservations sur un départ donné selon le format
        choisi, soit en PDF soit au format texte         */
        
        $produitRepo=$this->getRepo('Produit');
        
        $listeProduits=$produitRepo->getListeProduits();
        $form=$this->createForm(new ProduitExportType(), array());
        $form->bind($req);
        
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
         $listeProduits=$produitRepo->findByCategorie($data['categorie']);
        }
       //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
        //SI le format choisi est PDF 
        //if(strtolower($req->get('format'))=="pdf")
        //{//déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite passé à la fonction qui exporte les données, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($listeProduits as $produit)
        {
            $arr=array($produit->getNom(),
                $produit->getPrixAchat(),
                $produit->getPrixVente()
               );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //définition des colonnes du tableau
        $columns=array(
            array("name"=>"Produit", "width"=>60),
            array("name"=>"Prix Achat", "width"=>20),
            array("name"=>"Prix Vente", "width"=>20),
            ); 
        // déclarion des variables pour le fichier de sortie
        $filename='Liste des Produits.txt'; $titre="Liste des Produits GOlob One Shop ";
        //Exporter les données
        $tableExpoPDF->export($donnees, $columns, $filename, $titre);
        //}
        if(strtolower($req->get('format'))=="text")
        {
        ////déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de text
            //Cette variable sera ensuite passée à la fonction qui exporte les données, laquelle fonction prend en parametre
            //string et  non des objets
         
        $donnees_text='';
        foreach($listeRes as $res)
        {
             $client=$res->getClient();
                    $donnees_text.=$client->getPrenom(). ' '.$client->getNom()." \t "
                    .$client->getTel()." \t "
                    .$res->getNumPlace()." \t "
                    .$res->getPointDep()->getNom()." \t"
                            .$res->getPointDep()->$heur_function()->format('H\h:i')." \t"
                    .$res->getPointDep()->getArretBus()."\r\n";
        
         }
        
         $filename="Liste Départ ".$depart->getLibelle().'.txt'; $titre="Liste des inscrits pour la caravane ".$depart->getLibelle();
         $tableExpoText->export($donnees_text, $filename);
        }
           
        
    }
    /**
     * @Route("produit/refresh_static_data", name="refresh_produit")
     */
    public function updateAutoCompleteFileAction()
    {
        $ProuitController= $this->get('go_shop.static_data_generator');
         $ProuitController->updateCodeBarFile();
         $ProuitController->generateAucoCompleteProduitsFile();
        return new Response("Produits Actualisé");
    }
    /**
     * @Route("produit/code_bar/{codeBar}/get_details", name="code_bar_details_all", options={"expose"=true})
     */
    public function getDetailsCodeBarAction($codeBar)
    {
        $produits=$this->getRepo('Achat')->findByCodeBar($this->getShop(),$codeBar,['findAll'=>true]);
         $serializer=$this->get('jms_serializer');
        $rep= new Response($serializer->serialize(array("data"=>$produits),'json', SerializationContext::create()->enableMaxDepthChecks()));
        $rep->headers->set("Content-Type", "application/json");
        return $rep;
        
    }
    /**
     * @Route("produit/{nom}/get_details", name="produit_details_all", options={"expose"=true})
     * @ParamConverter("produit", class="GOShopBundle:Produit")
     */
    public function getDetailspProduitAction(Produit $produit)
    {
         $serializer=$this->get('jms_serializer');
        $rep= new Response($serializer->serialize(array("data"=>$produit),'json', SerializationContext::create()->enableMaxDepthChecks()));
        $rep->headers->set("Content-Type", "application/json");
        return $rep;
        
    }
}
