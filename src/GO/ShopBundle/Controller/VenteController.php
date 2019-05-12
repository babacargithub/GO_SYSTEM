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
use GO\ShopBundle\Form\VenteType;
use GO\ShopBundle\Form\VenteCodeBarType;
use GO\ShopBundle\Form\VenteEditType;
use GO\ShopBundle\Form\VenteFactType;
use GO\ShopBundle\Form\FactureVenteType;
use GO\ShopBundle\Form\VenteServiceType;
use GO\ShopBundle\Form\VenteSearchType;
use GO\ShopBundle\Form\SortieSearchType;
use GO\ShopBundle\Form\SortieType;
use GO\ShopBundle\Form\FactVenteToFactAchatType;
use GO\ShopBundle\Entity\Vente;
use GO\ShopBundle\Entity\Achat;
use GO\ShopBundle\Entity\FactureVente;
use GO\ShopBundle\Entity\DetteFacture;
use GO\ShopBundle\Entity\FactureAchat;
use GO\ShopBundle\Entity\VenteService;
use GO\ShopBundle\Entity\Stock;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\Caisse;
use GO\ShopBundle\Entity\Sortie;
use GO\SMSBundle\Form\AbonnementType;
use GO\SMSBundle\Entity\Abonnement;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormError;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * Description of VenteController
 *
 * @author hp
 */
class VenteController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouvelle Vente", "id"=>"", "href"=>"vente.golob"),
           array("libelle"=>"Vente Service", "id"=>"", "href"=>"vente_service_index.golob"),
           array("libelle"=>"Enregistrer  Facture", "id"=>"", "href"=> $this->generateUrl("vente_fac_index"),"exception"=>true),
           array("libelle"=>"Liste des Ventes", "id"=>"", "href"=>"#",
               "dropdown"=>array(
                               array("libelle"=>"Ventes Produit", "id"=>"", "href"=>"vente_show_today.golob"),
                                array("libelle"=>"Ventes Service", "id"=>"", "href"=>"vente_service_show_today.golob"),
                                )),
           array("libelle"=>"Recherche", "id"=>"", "href"=>"vente_search_index.golob"),
           array("libelle"=>"Caisse", "id"=>"", "href"=>"caisse_show.golob", 
                 "dropdown"=>array(
                                array("libelle"=>"Nouvelle Sortie", "id"=>"", "href"=>"caisse_index.golob"),
                                array("libelle"=>"Liste Sortie", "id"=>"", "href"=>"caisse_sortie_show.golob"),
                                array("libelle"=>"Recherche Sortie", "id"=>"", "href"=>"caisse_sortie_recherche.golob"),
                                array("libelle"=>"Nouvelle Entrée", "id"=>"", "href"=>"vente_search_index.golob"),
                                array("libelle"=>"Liste Entrée", "id"=>"", "href"=>"vente_search_index.golob"),
                     )
               
               ),
        array("libelle"=>"Les factures", "id"=>"", "href"=> $this->generateUrl("go_shop_vente_fact_month_list")),
              
           
           );
        return $this->render('@GOShop/Vente/menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    public function formAction(Request $req)
    {
       $Vente= new Vente();
        //$client=new Client();
        $form= $this->createForm(new VenteType(), $Vente);
        $formCodeBar= $this->createForm(new \GO\ShopBundle\Form\VenteCodeBarType(), $Vente);
        $formCodeBar->get('compteClient')->setData($this->getDoctrine()->getRepository("GOClientBundle:CompteClient")->find(1));
        return $this->render('GOShopBundle:Vente:index.html.twig', array(
            "form"=>$form->createView(),
            "form_"=>$formCodeBar->createView(),
             )
                );
     
        
        
    }
     
     /**
     * 
     * @return type
     * @Route("vente_facture_index.golob", name="vente_fac_index")
     */
     public function formFactureAction(Request $req)
    {
       $fact_vente= new FactureVente();
        //$client=new Client();
        $form= $this->createForm(new FactureVenteType(), $fact_vente);
  
                if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Vente:_form_fact_vente.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Vente:fact_vente_index.html.twig', array("form"=>$form->createView()));
     
        
        
    }
    public function serviceFormAction(Request $req)
    {
       $Vente= new VenteService();
        //$client=new Client();
        $form= $this->createForm(new VenteServiceType(), $Vente);
        return $this->render('GOShopBundle:Vente:service_vente_index.html.twig', array("form"=>$form->createView()));
     
        
        
    }
    public function addAction(Request $req)
    {
        
                
        $msg=null;
        $errorMsg=null;
       $request=$req;
         $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
        $produitRepo=$this->getRepo('Produit');
        $shop=$this->getShop();
         $Vente= new Vente();
        
        $produit=$produitRepo->findOneByNom(trim($req->get('go_shopbundle_ventetype')['produit']));
        
        $venteForm= $this->createForm(new VenteType(),$Vente);
       // $req->set("go_shopbundle_ventetype')['produit']",$produit);
        $venteForm->handleRequest($req);
        //=== vérifier si le formulaire est valide
         if($venteForm->isValid())
        {$Vente->setDate(new \DateTime());
        $Vente->setShop($shop);
        $Vente->setUser($this->getUser());
        $Vente->generateBenefice();
        $achat= $this->getRepo('Achat')->findByCodeBar($Vente->getShop(), $Vente->getProduit()->getDefaultCodeBar());
        if(null!==$achat)
        {
        $stock= $this->getRepo('Stock')->findOneBy(array('produit'=>$Vente->getProduit(), 'shop'=>$Vente->getShop()));
        
            //========== vérifie si le stock du produit à vendre n'est pas vide
             if($achat->getQuantiteRestant()>0)
             {
              $Vente->setCodeBar($achat);
              $em= $this->em();
              $em->persist($Vente);
              //$em->flush();
              //=============MODIFER LE STOCK
              $achat->setQuantiteRestant($achat->getQuantiteRestant()-$Vente->getQuantite());
              $stock->setLastUpdate(new \DateTime());
              //$em->persist($stock);
              $Caisse=$this->getCaisse();
              $Caisse->ajouter($Vente->getQuantite()*$Vente->getPrixUnit());
              $em->persist($Caisse);
              $em->flush();
              $msg="Vente enregistrée avec succès! Restant: ".$achat->getQuantiteRestant() ;
             }else
             {
                 $errorMsg="Stock insuffissant pour le produit ".$Vente->getProduit()->getNom().'. Restant: '.$achat->getQuantiteRestant().'';
             }
            return $this->sendResponse(array(
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
        }
        }else
        {
        return $this->render('@GOShop/Vente/index.html.twig',
              array("msg"=>$msg,
             "errorMsg"=>"Formulaire invalide. Les données saisies ne sont pas correctes!",
               'form'=>$venteForm->createView()
                ));
        
        }
      
        }
        /**
         * 
         * @param Request $req
         * @return type
         * @Route("vente_code_bar", name="vente_code_bar")
         */
    public function addVenteCodeBarAction(Request $req)
    {
        
                
        $msg=null;
        $errorMsg=null;
        $request=$req;
        $em=$this->em();
        $produitRepo=$this->getRepo('Produit');
        $shop=$this->getShop();
        $Vente= new Vente();
        $produit=$produitRepo->findOneByNom(trim($req->get('go_shopbundle_ventetype')['produit']));
        //======================
        $venteForm= $this->createForm(new VenteCodeBarType(),$Vente);
        $venteForm->bind($req);
        //=== vérifier si le formulaire est valide
        $achat=$this->getRepo('Achat')->findByCodeBar($this->getShop(),$Vente->getCodeBar());
        if(is_null($achat) ||empty($achat))
        {
            throw new NotFoundHttpException('Aucun produit n\'est associé avec ce code barre!');
        }
        $Vente->setCodeBar($achat);
        $Vente->setProduit($achat->getProduit());
        
        if($venteForm->isValid())
        {
            $Vente->setDate(new \DateTime())
                    ->setShop($shop)
                    ->setUser($this->getUser())
                    ->generateBenefice(intval($achat->getPrixUnit()));
           //========== vérifie si le stock du produit à vendre n'est pas vide
             if(!$achat->isStockVide()&& $achat->isStockDispo($Vente->getQuantite()))
             
             {
             $em= $this->em();
              $em->persist($Vente);
              
              //=============MODIFER LE STOCK
              $achat->setQuantiteRestant($achat->getQuantiteRestant()-$Vente->getQuantite());
              $achat->setLastUpdate(new \DateTime());
              $em->persist($achat);
              
              //récupération et augmentation de la caisse
              $Caisse=$this->getCaisse();
              $Caisse->ajouter($Vente->getQuantite()*$Vente->getPrixUnit());
              $em->persist($Caisse);
            //=============== commit de toutes les opérations en transactionnele
              $em->flush();
              // si la vente a réussi, on définit un message de succès!
              
               $msg='Vente avec Code Bar '.$Vente->getProduit()->getNom(). ' enregistrée avec succès! Restant : '.$achat->getQuantiteRestant();
             }else
             {
                 $errorMsg="Stock insuffissant pour le produit ".$Vente->getProduit()->getNom().'. Restant: '.$achat->getQuantiteRestant().'';
             }
            return $this->sendResponse(array(
               "view"=>'@GOShop/Vente/index.html.twig',
                "responseVars"=>array(),
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
        }else
        {
            $errorMsg="Formulaire invalide. Les données saisies ne sont pas correctes!";
        return $this->render('@GOShop/Vente/index.html.twig',
               array('form'=>$venteForm->createView(),
                   "errorMsg"=>$errorMsg
                )
                );
        
        }
      
        }
        
     
     /**
     * 
     * @return type
     * @Route("vente_facture_new.golob", name="go_shop_vente_fact_add")
     */
    public function factureAddAction(Request $req)
    { 
        //===Les variables qui contiennent les différents messages qui le Controlleur pourrait retourner;
        //Ces variables valeunt null au départ, cest au Controlleur de les modifier selon les messages qu'il doit retourner
        $msg=null;
        $errorMsg=null;
        //un tableau dans lequel nous allons stocker les produits dont les stocks sont insuffisants
         $empty_stocks=array();
         $has_empty_stocks=false;
        //=================
       $facture=new FactureVente();
        $venteForm= $this->createForm(new FactureVenteType(),$facture);
        //===========Binding the request 
        $venteForm->bind($req);
        
        // ===========Chaque facture doit avoir un numéro unique; on appelle le generateur de numéro de facture
        $facture->setNum(Date('mdysi'));
        //=======================
        $facture->setShop($this->getShop());
        $facture->setUser($this->getUser());
        $facture->setDate(new \DateTime());
        $em=$this->em();
        $Stock= $this->getRepo('Stock');
        $facture_paye=$facture->getPaye();
        $Caisse=$this->getCaisse();
              
        //==========Parcours la liste des ventes attachés à l'objet facture et les attaches à la facture pour la persistance
        foreach($facture->getVentes()->getIterator() as $i=>$object)
        {
        $facture->getVentes()[$i]->setFacture($facture);
        $facture->getVentes()[$i]->setDate(new \DateTime());
        $facture->getVentes()[$i]->generateBenefice();
        $facture->getVentes()[$i]->setShop($this->getShop());
        $facture->getVentes()[$i]->setUser($this->getUser());
         $em->persist($facture->getVentes()[$i]);
       
        // ========== accéder au stock du produit vendu et le diminuer selon la quantié vendue
        $stock=$Stock->findOneBy(array("produit"=>$facture->getVentes()[$i]->getProduit(), "shop"=> $this->getShop()));
        // ===== on vérifie si on peut accéder au stock; si tel n'esét pas le cas on lance une exception qui arrete le script
      
        if($stock!==null)
        {
            $quantite=$facture->getVentes()[$i]->getQuantite();
            if($stock->isDispo($quantite))
            {
            $stock->diminuer($quantite);
            $em->persist($stock);
            }else
            {
                //si la quantité demandée n'est pas disponible, alors on ajoute le stock à la liste des produits
                //dont le stock est vide;
                $has_empty_stocks=true;
                array_push($empty_stocks, $stock);
            }
        
        }else
        {
            throw new NotFoundHttpException("Stock du produit inexistant ou inaccessible");
        }
        }
        //On persiste la factue
       $em->persist($facture);
       //si la facture n'est pas payé on enregistre la dette
       if($facture->getPaye()==false)
       {
       /*$Dette=new DetteFacture();
       $Dette->setFacture($facture);
       $Dette->setDateEcheance(new \DateTime("+ 30 days"));
       $Dette->setMontant($facture->getTotal());
       $Dette->setShop($this->getShop())->setUser($this->getUser());
       $em->persist($Dette);
        // enregisterement des opérations en bdd
        */
       } 
       //print_r($empty_stocks); exit();
       //if(empty($empty_stocks))
       if($has_empty_stocks==false)
       {
       $em->flush(); 
         $msg="Enregistrement de la facture réuissi. Ventes effectuées!";
       }else
       {
           $errorMsg="Erreur: le stock de certains produits est insuffisant:";
           foreach ($empty_stocks as $stock)
           {
               $errorMsg.="//".$stock->getProduit()->getNom().",==Quantité dispo: ".$stock->getQuantite()."--";
           }
               
       }
         
      return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
        
}
/**
     * 
     * @return type
     * @Route("vente_fact_show.golob", name="go_shop_vente_fact_month_list")
     */
public function factureShowListeAction(Request $req)
    {
           $shop=$this->getShop();
            $achatRepo=$this->getRepo('FactureVente');
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::MOIS);
           return $this->render('GOShopBundle:Vente:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
        }
        /**
     * 
     * @return type
     * @Route("vente_fact_show_produits-{id}.golob", name="go_shop_vente_show_produits_fact")
     */
    public function factureShowAction(FactureVente $facture, Request $req)
    {
           
           return $this->render('GOShopBundle:Vente:fact_show.html.twig', array('facture'=>$facture));
    }
        /**
     * 
     * @return type
     * @Route("fact_vente_to_achat-{id}-index.golob", name="fact_vente_transform_index")
     */
    public function factureVenteToAchatIndexAction(FactureVente $facture, Request $req)
    {
        $factureToAchat=array("facture"=>$facture);
       $form= $this->createForm(new FactVenteToFactAchatType($this->get('session')),$factureToAchat);
      // $form->set("go_shopbundle_ventetype')['produit']",$produit);
        //$form->bind($req);
      return $this->render('GOShopBundle:Vente:fact_vente_to_fact_achat.html.twig', 
                array('form'=>$form->createView(),"facture"=>$facture));
    }
        /**
     * 
     * @return type
     * @Route("fact_vente_to_achat-{id}.golob", name="go_shop_fact_vente_transform")
     * @ParamConverter("facture", options={"mapping": {"id":"id"}})
     * @ParamConverter("shop", options={"mapping": {"shop": "id"}})
     */
    public function factureVenteToAchatAction(FactureVente $factureVente, Request $req)
    {
       // $factureToAchat=array("facture"=>$facture);
        $factureToAchat=array();
       $form= $this->createForm(new FactVenteToFactAchatType($this->get('session')),$factureToAchat);
       $form->bind($req);
       $factureToAchat=$form->getData();
       $shopOrigine=$factureVente->getShop();
       
       $shopDesti=$factureToAchat['shop'];
      // var_dump($shopDesti);die();
        $msg=null;
        $errorMsg=null;
        //=================
       $facture=new FactureAchat();
        // ===========Chaque facture doit avoir un numéro unique; on appelle le generateur de numéro de facture
         //=======================
        $fournisseur= $this->getRepo('Fournisseur')->findOneByNom(ucfirst($shopOrigine->getLibelle()));
        if($fournisseur==null)
        {
            $errorMsg="Imporssible de trouver le fournssier!";
            return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
               "msg"=>"Données envoyées",
             "errorMsg"=>$errorMsg));
            //return $this->render('GOShopBundle::layout.html.twig', array("errorMsg"=>"Imporssible de trouver le fournssier!"));
        }
        $facture->setFournisseur($fournisseur)
        ->setNum(Date('mdysi'))
        ->setShop($shopDesti)
        ->setUser($this->getUser())
        ->setDateFacture(new \DateTime())
        ->setPaye($factureVente->getPaye())
        ->setAvance($factureVente->getAvance())
        ->setLivre($factureVente->getLivre())
        ->setDateFacture($factureVente->getDate());
        $em=$this->em();
        $Stock= $this->getRepo('Stock');
        $facture_paye=$factureToAchat['paye'];
        //var_dump($facture);die();
        //==========Parcours la liste des achats attachés à l'objet facture et les attaches à la facture pour la persistance
        foreach($factureVente->getVentes() as $vente)
        {
            //hydrating achat objet
            $achat=new Achat();
        $achat->setPrixUnit($vente->getPrixUnit())
        ->setProduit($vente->getProduit())
        ->setPrixVente($vente->getProduit()->getPrixVente())
        ->setDate($facture->getDate())
         ->setQuantite($vente->getQuantite())
          ->setShop($facture->getShop())      
          ->setUser($facture->getUser()) 
          ->setPaye($facture_paye) ;
        //======================
        $facture->addAchat($achat);
        // ========== accéder au stock du produit acheté et l'augmenter selon la quantié achetée
        $stock=$Stock->findOneBy(array("produit"=>$achat->getProduit(), "shop"=>$shopDesti));
        // ===== on vérifie si on peut accéder au stock; si tel n'esét pas le cas on lance une exception qui arrete le script
            $not_fond_prod=array();
             if($stock!==null)
             {
            $stock->augmenter($achat->getQuantite());
             $em->persist($stock);
             }else
             {
                 array_push($not_fond_prod, $stock);
              }
        }
        
        //si la facture n'est pas payé on enregistre la dette
        if($facture->getPaye()==false)
       {
       $Dette=new DetteFacture();
       $Dette->setFacture($facture);
       $Dette->setDateEcheance(new \DateTime("+ 30 days"));
       $Dette->setMontant($facture->getTotal());
       $Dette->setShop($shopDesti)->setUser($this->getUser());
       $em->persist($Dette);
        // enregisterement des opérations en bdd
        
       } 
    //On persiste la factue
       $em->persist($facture);
       $em->flush(); 
       $msg="Enregistrement de la facture réuissi. Achats effectués";
         
      return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
    }
        /**
     * 
     * @return type
     * @Route("fact_vente_export-{id}-{format}.golob", name="go_shop_fact_vente_export")
      * @param FactureVente $facture
      * @param Request $req
     */
    public function factureVenteExportAction(FactureVente $facture, Request $req)
    {
         $donnees=array();
           $columns=array();
       //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        $listeProduits=$facture->getVentes();
        
       //Instantitiation des classes qui gèrenet les exportations selon le format choisi
        $tableExpoPDF = new \GO\MainBundle\Utils\PDFTableExporter;
        $tableExpoText = new \GO\MainBundle\Utils\TextExporter;
        
        //SI le format choisi est PDF 
        //if(strtolower($req->get('format'))=="pdf")
        //{//déclaration de la variable de base, à laquelle nous ajouterons les objets sous forme de tableau
            //Cet array sera ensuite passé à la fonction qui exporte les données, laquelle fonction prend en parametre
            //un tableau et non des objets
            $donnees=array();
            
        foreach($listeProduits as $vente)
        {
            $arr=array($vente->getProduit()->getNom(),
                $vente->getQuantite(),
                $vente->getPrixUnit(),
                number_format($vente->getQuantite()*$vente->getPrixUnit(), 0, ',',' '),
               );
                array_push($donnees, $arr);
        }
       
        //================PREPARATION DES DONNEES POUR L'EXPORT
        //définition des colonnes du tableau
        $columns=array(
            array("name"=>"Produit", "width"=>60),
            array("name"=>"Prix Quantié", "width"=>30),
            array("name"=>"Prix Vente", "width"=>30),
             array("name"=>"Prix Total", "width"=>30),
            ); 
        // déclarion des variables pour le fichier de sortie
        $filename='Facture-'.$facture->getNum().''; $titre='Date: '.$facture->getDate()->format('d-m-Y').'// Facture N°'.$facture->getNum()." pour le client".$facture->getClient()->getPrenom().' '.$facture->getClient()->getNom();
        //Exporter les données
        $tableExpoPDF->export($donnees, $columns, $filename, $titre,'',number_format($facture->getTotal(),0,',',' '));
        }
    public function serviceAddAction(Request $req)
    {
         $msg=null;
        $errorMsg=null;
        $CustomValidator=$this->get('gocar.custom_validator');
        $em=$this->em();
        $shop=$this->getShop();
        $Vente= new VenteService();
        $venteForm= $this->createForm(new VenteServiceType(),$Vente);
        $venteForm->bind($req);
        $Vente->setShop($shop);
        $Vente->setUser($this->getUser());
        $service= $this->getRepo('Service')->find($Vente->getService());
        if(!empty($service))
        {
        
            if($venteForm->isValid())
           {
                $em= $this->em();
                 $em->persist($Vente);
                 $Caisse=$this->getRepo('Caisse')->find($Vente->getShop());
                 $Caisse->ajouter($Vente->getMontant());
                 $em->persist($Caisse);
                 $em->flush();
                 $msg="Vente Service enregistrée avec succès!";

               return $this->sendResponse(array(
                  "view"=>'GOShopBundle:Vente:index.html.twig',
                   "responseVars"=>array(
                  "msg"=>$msg,
                  "error"=>$errorMsg)
                   ));
           }else
           {
           return $this->sendResponse(array(
                  "view"=>'GOShopBundle:Vente:index.html.twig',
                  "msg"=>$msg,
                "errorMsg"=>$errorMsg
                  //"responseVars"=> array('form'=>$resForm->createView()
                   ));

           }
           
           }
           else
           {
               throw NotFoundHttpException('Service inconnu');
           }
        
        }
    public function deleteAction(Vente $vente, Request $req)
        {
             $msg=null;
            $errorMsg=null;
            
                $em=$this->em();
                $em->remove($vente);
               
                if(!is_null($vente->getFacture()))
                    
                if(!$vente->getFacture()->isValidated())
                        
                if($vente->getCodeBar()==null)
                {
                $Stock=$this->getRepo('Stock')->findOneBy(array('shop'=> $this->getShop(), 'produit'=>$vente->getProduit()));
                $Stock->setQuantite($vente->getQuantite()+$Stock->getQuantite());
                $em->persist($Stock);
                }else
                {
                    $achat=$vente->getCodeBar();
                    $achat->setQuantiteRestant($achat->getQuantiteRestant()+$vente->getQuantite());
                    $em->persist($achat);
                }
                try {
                    if(intval($vente->getDate()->format('dmY'))>=intval(\DATE('dmY')))
                    {
                        $Caisse=$this->getCaisse();
                        $Caisse->diminuer($vente->getTotal());
                        $em->persist($Caisse);
                    }else
                    {
                        if($this->get('security.context')->isGranted('ROLE_SUP_BOUT'))
                        {
                            $Caisse=$this->getCaisse();
                        $Caisse->diminuer($vente->getTotal());
                        $em->persist($Caisse);
                        }else
                        {
                            return $this->sendResponse(array("errorMsg"=>"Vous n'êtes pas autorisé à annuler une vente passée. Seul le Superviseur est autorisé à le faire"));
                        }
                    }
                   $em->flush();
                   $msg="Vente annulée avec succès!";
                   
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
                 return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
            
        }
    public function serviceDeleteAction(VenteService $vente,Request $req)
        {
            $msg=null;
            $errorMsg=null;
            if(!is_null($vente))
            {
                $em=$this->em();
                $em->remove($vente);
                $Caisse= $this->getRepo('Caisse')->find($this->getShop());
                $Caisse->diminuer($vente->getMontant());
                $em->persist($Caisse);
                try {
                   $em->flush();
                   $msg="Vente Service annulée avec succès!";
                   
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
                 return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
            }else
            {
                throw new NotFoundHttpException('Vente Introuvable!');
            }
        }

        public function showTodayAction(Request $req)
        {
           $shop=$this->getShop();
            $venteRepo=$this->getRepo('Vente');
           $liste_ventes= $venteRepo->getListeVente($shop,Cons::AUJOURDHUI);
           $benefice= $venteRepo->getTotalBenefice($shop,Cons::AUJOURDHUI);
           
           $total_ventes= $venteRepo->getTotalVente($shop,Cons::AUJOURDHUI);
           
           return $this->render('GOShopBundle:Vente:liste_vente.html.twig', array('ventes'=>$liste_ventes, 'total_ventes'=>$total_ventes, "benefice"=>$benefice));
        }
        public function serviceShowTodayAction(Request $req)
        {
           $shop=$this->getShop();
            $venteRepo=$this->getRepo('VenteService');
           $liste_ventes= $venteRepo->getListeVente($shop,Cons::AUJOURDHUI);
           
           $total_ventes= $venteRepo->getTotalVente($shop,Cons::AUJOURDHUI);
           
           return $this->render('GOShopBundle:Vente:service_vente_liste.html.twig', array('ventes'=>$liste_ventes, 'total_ventes'=>$total_ventes));
        }
    public function showSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new VenteSearchType(),$data);
         return $this->render('GOShopBundle:Vente:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    
    public function searchAction(Request $req)
    {
        $clientRepo=$this->getRepo('Client');
        $venteRepo=$this->getRepo('Vente');
        $liste= null;
        $ventes=null;
        $total_vente=null;
        $total_benefice=null;
        $form=$this->createForm(new VenteSearchType(), array());
        $form->bind($req);
        $shop= $this->getShop();
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'total': $total_vente=$venteRepo->getTotalVente($shop,Cons::DATE_INTERVALLE,'', $data['debut'], $data['fin']);
                break;
            case 'liste': $ventes=$venteRepo->getListeVente($shop,Cons::DATE_INTERVALLE,'', $data['debut'], $data['fin']);
                break;
            case 'benefice': $total_benefice=$venteRepo->getTotalBenefice($shop,Cons::DATE_INTERVALLE,'', $data['debut'], $data['fin']);
                break;
            
        }
        
            }
        return $this->render('GOShopBundle:Vente:search_result.html.twig', array('ventes'=>$ventes, 'total_vente'=>$total_vente, 'total_benefice'=>$total_benefice));
        
    }
  
    /**
     * 
     * @return type
     * @Route("caisse_sortie_recherche.golob", name="sortie_recherche_index")
     */
    public function sortieSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new SortieSearchType(),$data);
         return $this->render('GOShopBundle:Caisse:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("sortie_search.golob", name="sortie_search")
     */
public function sortieSearchAction(Request $req)
    {
       
        $sortieRepo=$this->getRepo('Sortie');
        $liste= null;
        $sorties=null;
        $total_sortie=null;
        $total_benefice=null;
        $form=$this->createForm(new SortieSearchType(), array());
        $form->handleRequest($req);
        $shop= $this->getShop();
         $totaux_poste_dep=array();
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);die();
        switch ($data['type_search'])
        {
            case 'total': $total_sortie=$sortieRepo->getTotalSortie($shop,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
                break;
            case 'liste': $sorties=$sortieRepo->getListeSortie($shop,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            $total_sortie=$sortieRepo->getTotalSortie($shop,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']);
            break;
        
            case 'poste_depense':
                $type=$this->getRepo('Charge')->find($data['typeSortie']->getId());
                $sorties=$sortieRepo->getListeTypeSortie($shop, $type,Cons::DATE_INTERVALLE,$data['date_debut'], $data['date_fin']);
            
            break;  
         }       $postDepRepo=$this->getRepo('Charge');
        $posteDepenes=$postDepRepo->findAll();
       
        foreach($posteDepenes as $posteDep)
        {
            $tot=array("montant"=>$sortieRepo->getTotalSortieType($this->getShop(),$posteDep,Cons::DATE_INTERVALLE, $data['date_debut'], $data['date_fin']),
                    "libelle"=>$posteDep->getLibelle());
                array_push($totaux_poste_dep, $tot);
        }
             
            
        
        
            }
        return $this->render('GOShopBundle:Caisse:liste.html.twig', array('sorties'=>$sorties, 
            'total_sortie'=>$total_sortie,
                "total_postes"=>$totaux_poste_dep));
   
       }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("caisse/get_balance", name="caisse_show_balance", options={"expose"=true})
     */
    public function showCaisseAction(Request $req)
    {
        $caisse=$this->getRepo('Caisse')->findOneByShop($this->getShop());
        return $this->render('GOShopBundle:Vente:caisse.html.twig', array('caisse'=>$caisse));
    }
    public function sortieFormAction(Request $req)
    {
        $Sortie= new Sortie();
        //$client=new Client();
        $form= $this->createForm(new SortieType(), $Sortie);
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Caisse:_form_sortie.html.twig', array("form"=>$form->createView()));
     else
        return $this->render('GOShopBundle:Caisse:index.html.twig', array("form"=>$form->createView()));
     
    }
    public function sortieAddAction(Request $req)
    {
         $msg=null;
        $errorMsg=null;
       $request=$req;
         $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
         $shop=$this->getShop();
         $Sortie= new Sortie();
        $sortieForm= $this->createForm(new SortieType(),$Sortie);
        $sortieForm->bind($req);
        $Sortie->setDate(new \DateTime());
        $Sortie->setShop($shop);
        $Sortie->setUser($this->getUser());
        //=== vérifier si le formulaire est valide
         if($sortieForm->isValid())
        {
            //========== vérifie si le stock du produit à vendre n'est pas vide
             if(Validator::isValideMontant($Sortie->getMontant()))
             {
             $em= $this->em();
             
              $em->persist($Sortie);
              $em->flush();
              $Caisse=$this->getRepo('Caisse')->find($Sortie->getShop());
              $Caisse->diminuer($Sortie->getMontant());
              $em->persist($Caisse);//var_dump($Caisse); die();
              $em->flush();
              $msg="Sortie enregistrée avec succès!";
             }else
             {
                 $errorMsg="Montant invalide";
             }
            return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
                "responseVars"=>array(),
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
            
        }else
        {
        return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
        
        }
        
    }
    public function sortieShowAction(Request $req)
    {
        $sortieRepo=$this->getRepo('Sortie');
        $postDepRepo=$this->getRepo('Charge');
        $posteDepenes=$postDepRepo->findAll();
        $totaux_poste_dep=array();
        foreach($posteDepenes as $posteDep)
        {
            $tot=array("montant"=>$sortieRepo->getTotalSortieType($this->getShop(),$posteDep,Cons::MOIS),
                    "libelle"=>$posteDep->getLibelle());
                array_push($totaux_poste_dep, $tot);
        }
        $sorties=$sortieRepo->getListeSortie($this->getShop(), Cons::MOIS);
        $total=$sortieRepo->getTotalSortie($this->getShop(), Cons::MOIS);
        return $this->render('GOShopBundle:Caisse:liste.html.twig', array('sorties'=>$sorties, 
                                                                            'total_sortie'=>$total,
                                                                            "total_postes"=>$totaux_poste_dep));
    }
    public function sortieDeleteAction(Request $req)
        {
            $sortie= $this->getRepo('Sortie')->find($req->get('id'));
            
            $msg=null;
            $errorMsg=null;
            if(!is_null($sortie))
            {
                $em=$this->em();
                $em->remove($sortie);
                $Caisse=$this->getCaisse();
                $Caisse->ajouter($sortie->getMontant());
                $em->persist($Caisse);
                try {
                   $em->flush();
                   $msg="Sortie  annulée avec succès!";
                   
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
                 return $this->sendResponse(array(
               "view"=>'GOShopBundle:Vente:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
            }else
            {
                throw new NotFoundHttpException('Vente Introuvable!');
            }
        }
        /**
     * 
     * @param Vente $vente
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("vente_update-{id}.golob", name="update_vente")
     * 
     */
    public function updateAction(Vente $vente,Request $req)
    {
        
       //$form= $this->createForm(new VenteEditType(), $vente);
        //$facture= $this->getRepo('FactureVente')->find(7);
       $oldQuantite=$vente->getQuantite();
       $stock= $this->getRepo('Stock')->findOneBy(array("shop"=>$this->getShop(),"produit"=>$vente->getProduit()));
       if(!empty($stock))
       {
           $stock->augmenter($oldQuantite);
       }else
       {
           exit("Stock Non trouvé");
       }
       $form= $this->createForm(new VenteEditType(), $vente);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                $stock->diminuer($vente->getQuantite());
                $em= $this->em();
                $vente->generateBenefice();
                $em->persist($vente);
                $em->flush();
            return $this->sendResponse(array('msg'=>'Modifactions enregistrées avec succès!'));
            }
            else
            {
            return $this->render('GOShopBundle:Vente:_update_form.html.twig', array("form"=>$form->createView(), "vente"=>$vente));
     
            return $this->sendResponse(array('errorMsg'=>'Données saisies non valides!'));
            }
            
        }
                if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Vente:_update_form.html.twig', array("form"=>$form->createView(), "vente"=>$vente));
     else
        return $this->render('GOShopBundle:Vente:_update_form.html.twig', array("form"=>$form->createView(),"vente"=>$vente));
        
     }
        
        //=============================SMS========================
        
     /**
     * 
     * @param \GO\ShopBundle\Controller\FactureVente $facture
     * @param Request $req
     * @Route("facture_vente/{id}/add_produit", name="facture_vente_add_produit")
     */
   public function addProduitOnFactureAction(FactureVente $facture, Request $req)
   {
       $vente = new Vente();
       $vente->setFacture($facture);
       $factureForm= $this->createForm(new VenteType(), $vente);
       $factureFormCodeBar= $this->createForm(new VenteCodeBarType(), $vente);
        if($req->getMethod()=="POST")
       {
        
           $factureForm->handleRequest($req);   
            $vente->setShop($this->getShop());
            $vente->setUser($this->getUser());
            $vente->setDate(new \DateTime());
               
            if($factureForm->isValid())
            {       $em= $this->em();
                 $em->persist($vente);
                 $em->flush();
            return $this->sendResponse(array('msg'=>'Produit ajouté  avec succès!'));
            }else
            {
                return $this->render('@GOShop/Vente/_new_to_fact.html.twig', array(
                    'form'=>$factureForm->createView(),
                    'formCodeBar'=>$factureFormCodeBar->createView(),
                    "facture"=>$facture));
            }
       }else
       {
           return $this->render('@GOShop/Vente/_new_to_fact.html.twig',array(
                                                                        'form'=>$factureForm->createView(),
                                                                        'formCodeBar'=>$factureFormCodeBar->createView(),
                                                                        "facture"=>$facture));
       }
       
       
   }
     /**
     * 
     * @param \GO\ShopBundle\Controller\FactureVente $facture
     * @param Request $req
     * @Route("facture_vente/{id}/add_produit_code_bar", name="facture_vente_add_produit_code_bar")
     */
   public function addProduitCodeBarOnFactureAction(FactureVente $facture, Request $req)
   {
        
                
        $msg=null;
        $errorMsg=null;
        $request=$req;
        $em=$this->em();
        $produitRepo=$this->getRepo('Produit');
        $shop=$this->getShop();
        $Vente= new Vente();
        $Vente->setFacture($facture);
        //$produit=$produitRepo->findOneByNom(trim($req->get('go_shopbundle_ventetype')['produit']));
        //======================
        $venteForm= $this->createForm(new VenteType(),$Vente);
        $venteCodeBarForm= $this->createForm(new VenteCodeBarType(),$Vente);
        $venteCodeBarForm->bind($req);
        //=== vérifier si le formulaire est valide
        $achat=$this->getRepo('Achat')->findByCodeBar($this->getShop(),$Vente->getCodeBar());
        if(is_null($achat) ||empty($achat))
        {
           $errorMsg='Codde Barre Introuvable: Aucun produit n\'est associé avec ce code barre!';
           return $this->sendResponse(array(
               "view"=>'@GOShop/Vente/_new_to_fact.html.twig',
                "responseVars"=>array(),
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
        }
        $Vente->setCodeBar($achat);
        $Vente->setProduit($achat->getProduit());
        
        if($venteCodeBarForm->isValid())
        {
            $Vente->setDate(new \DateTime())
                    ->setShop($shop)
                    ->setUser($this->getUser())
                    ->generateBenefice(intval($achat->getPrixUnit()));
           //========== vérifie si le stock du produit à vendre n'est pas vide
             if(!$achat->isStockVide()&& $achat->isStockDispo($Vente->getQuantite()))
             
             {
             $em= $this->em();
              $em->persist($Vente);
             //=============== commit de toutes les opérations en transactionnele
              $em->flush();
              // si la vente a réussi, on définit un message de succès!
              
               $msg='Succès: '.$Vente->getProduit()->getNom(). ' ajouté à la facture avec succès!  : ';
             }else
             {
                 $errorMsg="Stock insuffissant pour le produit ".$Vente->getProduit()->getNom().'. Restant: '.$achat->getQuantiteRestant().'';
             }
            return $this->sendResponse(array(
               "view"=>'@GOShop/Vente/_new_to_fact.html.twig',
                "responseVars"=>array(),
               "msg"=>$msg,
               "errorMsg"=>$errorMsg
                ));
        }else
        {
            $errorMsg="Formulaire invalide. Les données saisies ne sont pas correctes!";
        return $this->render('@GOShop/Vente/_new_to_fact.html.twig',
               array(
                   'formCodeBar'=>$venteCodeBarForm->createView(),
                   'form'=>$venteForm->createView(),
                   "errorMsg"=>$errorMsg
                )
                );
        
        }
      
        }
        
        /**
    * 
    * @param FactureAchat $facture
    * @param Request $req
    * @Route("/facture_vente/{id}/details/{format}", name="details_facture_vente", defaults={"format"="jason"}, options = { "expose" = true })
    */
   public function detailsFactureAction(FactureVente $facture, Request $req)
   {
       $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer=new ObjectNormalizer();
       // $normalizer->setCircularReferenceLimit(count($facture->getVentes())+2);
        $normalizer->setCircularReferenceHandler(function ($object) {
    return "facture";});
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($facture, 'json');

// $jsonContent contains {"name":"foo","age":99,"sportsperson":false,"createdAt":null}

        //echo $jsonContent;
       return new Response($jsonContent);
   }
        /**
    * 
    * @param FactureAchat $facture
    * @param Request $req
    * @Route("/facture_vente/{id}/process", name="facture_vente_validate")
    */
   public function validateFactureAction(FactureVente $facture, Request $req)
   {
       $StockRepo= $this->getRepo("Stock");
       $em= $this->em();
       
        foreach($facture->getVentes()->getIterator() as $i=>$vente)
        {
            // ========== accéder au stock du produit acheté et l'augmenter selon la quantié achetée
            if($vente->getCodeBar()==null)
            {
               
                $stock=$StockRepo->findOneBy(array("produit"=>$vente->getProduit(), "shop"=> $facture->getShop()));
                // ===== on vérifie si on peut accéder au stock; si tel n'esét pas le cas on lance une exception qui arrete le script
                 if($stock!==null)
                { 
                     $stock->diminuer($vente->getQuantite());
                    $em->persist($stock);
                }else
                {throw new NotFoundHttpException("Stock du produit ".$vente->getProduit()." inexistant ou inaccessible");
              
                }
            }else
            {
               $achatRepo= $this->getRepo('Achat');
               $totalStockDispo= $achatRepo->getTotalStockCodeBar($this->getShop(),$vente->getCodeBar());
              $achat=$vente->getCodeBar();
              if($achat->isStockDispo($vente->getQuantite()))
              {
              $achat->setQuantiteRestant($achat->getQuantiteRestant()-$vente->getQuantite());
              $em->persist($achat);
              }else
              {
                  $quantiteAVendre=$vente->getQuantite();
                  $stocksUpdated=$achatRepo->venteSurMultiStockCodeBar($this->getShop(),$achat, $quantiteAVendre);
                 // var_dump($stocksUpdated);die();
                  foreach($stocksUpdated as $stock)
                  {
                  $em->persist($stock);
                  }
              }
              
            }
       } 
       $em->persist($facture);
       // si la facture a été payé, on doit augmenter son total dans la caisse
       // on doit aussi vérifier si la facture n'est pas déjà validée pour éviter de créditer 2 fois la caisse pour la seule facture
       if($facture->getPaye()&&$facture->isValidated()==false)
       {
        $caisse=$this->getCaisse();
        $caisse->ajouter($facture->getTotal());
        $em->persist($caisse);
       }
      
       $facture->setValidated(true)->setValidatedAt(new \DateTime());
       $em->flush();
       $this->addFlash("success", "Facture de vente validée avec succès!");
       return $this->render('@GOShop/flash_message.html.twig');
       
   }
   /**
    * 
    * @param FactureVente $facture
    * @param Request $req
    * @Route("/facture_vente/{facture_vente_id}/transform_to/shop/{target_shop_id}", name="facture_vente_validate_process")
    
    * @ParamConverter("factureVente", options={"mapping": {"facture_vente_id":"id"}})
    * @ParamConverter("targetShop", options={"mapping":{"target_shop_id": "id"}})
     **/
public function transformFactureVenteToFactureAchatAction(FactureVente $factureVente, Shop $targetShop,Request $req)
   {
       $targetFactureAchat=new FactureAchat();
       $targetFactureAchat->setShop($targetShop)
               ->setDate(new \DateTime())
               ->setFournisseur($this->getRepo('Fournisseur')->find(13))
               ->setDateFacture($factureVente->getDate())
               ->setAvance($factureVente->getAvance())
               ->setValidated(true)
               ->setValidatedAt(new \DateTime())
               ->setPaye($factureVente->getPaye())
               ->setLivre($factureVente->getLivre())
               ->setDateEcheance($factureVente->getDateEcheance())
               ->setNum(Date('dmyhi'))
               ->setUser($this->getUser())
               ;
               
       $em= $this->em();
       
        foreach($factureVente->getVentes()->getIterator() as $i=>$vente)
        {
            $produit=$vente->getProduit();
            $achat = new Achat();
            //=== On se servira des données de vente pour remplir les données de l'achat 
              $achat->setCodeBar($vente->getCodeBar())
                    ->setProduit($vente->getProduit())
                    ->setFacture($targetFactureAchat)
                    ->setDate(new \DateTime())
                    ->setPrixUnit($vente->getPrixUnit())
                    ->setPrixVente($produit->getPrixVente())
                    ->setPaye($targetFactureAchat->getPaye())
                    ->setQuantite($vente->getQuantite())
                    ->setQuantiteRestant($vente->getQuantite())
                    ->setLastUpdate(new \DateTime())
                    ;
              $targetFactureAchat->addAchat($achat);
              $StockRepo= $this->getRepo('Stock');
              $stock=$StockRepo->findOneBy(array("produit"=>$achat->getProduit(), "shop"=> $targetShop));
                // ===== on vérifie si on peut accéder au stock; si tel n'esét pas le cas on lance une exception qui arrete le script
                 if($stock!==null)
                {
                    $stock->augmenter($achat->getQuantite());
                    $em->persist($stock);
                }else
                {throw new NotFoundHttpException("Stock du produit ".$achat->getProduit()." inexistant ou inaccessible");
              
                }
            
       } 
       $em->persist($targetFactureAchat);
       // si la facture a été payé, on doit augmenter son total dans la caisse
       
        $em->flush();
       $this->addFlash("success", "Facture de vente Transformée en achat avec succès!");
       return $this->render('@GOShop/flash_message.html.twig');
       
   }
   /**
     * 
     * @param FactureAchat $facture
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_ADMIN")
     * @Route("facture_vente/delete/{id}", name="delete_facture_vente")
     * 
     */
    public function deleteFactureAction(FactureVente $facture, Request $req)
    {
           $msg=null;$errorMsg=null;
           $em=$this->em();
            foreach($facture->getVentes() as $vente)
                {
                    if(!is_null($vente->getCodeBar())&&$facture->isValidated())
                    {
                    $Stock=$this->getStock($vente->getProduit());
                    $Stock->setQuantite($vente->getQuantite()+$Stock->getQuantite());
                    $em->persist($Stock);
                    }
                    $em->remove($vente);
                } 
                if($facture->isValidated()&&$facture->isPaye())
                {
                    $caisse= $this->getCaisse();
                    $caisse->diminuer($vente->getTotal());
                    $em->persist($caisse);
                }
                    $em->remove($facture);
                try {
                   $em->flush();
                   $msg="Facture vente supprimée avec succès!";
                   
                } catch (Exception $ex) {
                    
                    return new Response($ex->getMessage());
                }
                
                 return new Response($msg);
            
        }     

}
