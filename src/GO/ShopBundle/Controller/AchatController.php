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
use GO\ShopBundle\Form\AchatType;
use GO\ShopBundle\Form\FactureAchatType;
use GO\ShopBundle\Form\AchatSearchType;
use GO\ShopBundle\Entity\Achat;
use GO\ShopBundle\Entity\FactureAchat;
use GO\ShopBundle\Entity\FactureAbstract;
use GO\ShopBundle\Entity\Stock;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\Caisse;
use GO\ShopBundle\Entity\DetteFacture;
use GO\ShopBundle\Utils\Constants as Cons;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * Description of AchatController
 *
 * @author hp
 */
class AchatController extends MainController {
    //put your code here
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Enregistrer Facture", "id"=>"", "href"=>"achat_fact_index.golob", "exception"=>true),
           array("libelle"=>"Factures Du Jour", "id"=>"", "href"=>$this->generateUrl("go_shop_achat_show_today")),
           array("libelle"=>"Recherche", "id"=>"", "href"=>"achat_search_index.golob"),
           array("libelle"=>"Fournisseurs", "id"=>"", "href"=>"", 
                 "dropdown"=>array(
                                array("libelle"=>"Créer Fournisseur", "id"=>"", "href"=>"fournisseur_index.golob"),
                                array("libelle"=>"Liste Fournisseurs", "id"=>"", "href"=>"fournisseur_show.golob"),
                                
                     )
               
               ),
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    public function formAction(Request $req)
    {
       $achat= new Achat();
       $form= $this->createForm(new AchatType(), $achat);
       return $this->render('GOShopBundle:Achat:index.html.twig', array("form"=>$form->createView()));
   }
    public function formFactureAction(Request $req)
    {
       $fact_achat= new FactureAchat();
        $form= $this->createForm(new FactureAchatType(), $fact_achat);
        return $this->render('GOShopBundle:Achat:_form_fact_achat.html.twig', array("form"=>$form->createView()));
     
        
        
    }
    /**
     * 
     * @param FactureAchat $facture
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("achat_update_facture-{id}.golob", name="facture_achat_update")
     * 
     */
    public function updateFactureAction(FactureAchat $facture_updated,Request $req)
    {
        
        $form= $this->createForm(new FactureAchatType(), $facture_updated);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                $em= $this->em();
                
                $em->persist($facture_updated);
                $em->flush();
            return $this->sendResponse(array('msg'=>'Modifactions enregistrées avec succès!'));
            }
            else
                return $this->render('GOShopBundle:Achat:_update_form_fact_achat.html.twig', array("form"=>$form->createView()));
            
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
             return $this->render('GOShopBundle:Achat:_update_form_fact_achat.html.twig', array("form"=>$form->createView()));
            
     }
    /**
     * 
     * @param Achat $achat
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("achat/update/{id}", name="update_achat")
     * 
     */
    public function updateAchatAction(Achat $achat,Request $req)
    {
        
       $form= $this->createForm(new AchatType(), $achat);
        if($req->getMethod()=="POST")
        {
            $form->bind($req);
            if($form->isValid())
            {
                $em= $this->em();
                $em->persist($achat);
                $em->flush();
            return $this->sendResponse(array('msg'=>'Modifactions enregistrées avec succès!'));
            }
            else
            {
            return $this->sendResponse(array('errorMsg'=>'Données saisies non valides!'));
            }
            
        }
        return $this->render('GOShopBundle:Achat:_update_form.html.twig', array("form"=>$form->createView()));
        
     }
        
        
    
    public function addAction(Request $req, FactureAchat $facture)
    {
         $msg=null;
        $errorMsg=null;
          $CustomValidator=$this->get('gocar.custom_validator');
         $em=$this->em();
        $produitRepo=$this->getRepo('Produit');
        $shop=$this->getShop();
         $Achat= new Achat();
        $produit=$produitRepo->find($req->get('go_shopbundle_achattype')['produit']);
        if(!empty($produit))
        {
        $achatForm= $this->createForm(new AchatType(),$Achat);
        $achatForm->bind($req);
        $Achat->setDate(new \DateTime());
        $Achat->setShop($shop);
        $Achat->setUser($this->getUser());
        $Achat->setFacture($facture);
        $stock= $this->getRepo('Stock')->findOneBy(array('produit'=>$Achat->getProduit(), 'shop'=>$Achat->getShop()));
        //=== vérifier si le formulaire est valide
         if($achatForm->isValid())
        {
            
             $em= $this->em();
              $em->persist($Achat);
              
              //=============MODIFER LE STOCK
              $stock->setQuantite($stock->getQuantite()+$Achat->getQuantite());
              $stock->setLastUpdate(new \DateTime());
              $em->persist($stock);
              try {
                  $em->flush();
              } catch (Exception $ex) {
                  echo $ex->getMessage();
              }
              
                    
                    $msg="Achat enregistrée avec succès!";
             
            return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
                "responseVars"=>array(
               "msg"=>$msg,
               "error"=>$errorMsg)
                ));
        }else
        {
        return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
        
        }}
        
        }
    public function factureAddAction(Request $req)
    { 
        //===Les variables qui contiennent les différents messages qui le Controlleur pourrait retourner;
        //Ces variables valeunt null au départ, cest au Controlleur de les modifier selon les messages qu'il doit retourner
        $msg=null;
        $errorMsg=null;
        //=================
       $facture=new FactureAchat();
        //$facture=$this->getRepo('FactureAchat')->find(38);
        $achatForm= $this->createForm(new FactureAchatType(),$facture);
        //===========Binding the request 
        $achatForm->bind($req);
        // ===========Chaque facture doit avoir un numéro unique; on appelle le generateur de numéro de facture
        $facture->setNum(Date('mdysi'));
        //=======================
        $facture->setShop($this->getShop());
        $facture->setUser($this->getUser());
        $facture->setDateFacture(new \DateTime());
        $em=$this->em();
        $Stock= $this->getRepo('Stock');
        $facture_paye=$facture->getPaye();
        //var_dump($facture);die();
        //==========Parcours la liste des achats attachés à l'objet facture et les attaches à la facture pour la persistance
        foreach($facture->getAchats()->getIterator() as $i=>$object)
        {
            $facture->getAchats()[$i]->setFacture($facture);
            $facture->getAchats()[$i]->setPaye($facture_paye);
            $em->persist($facture->getAchats()[$i]);
            // ========== accéder au stock du produit acheté et l'augmenter selon la quantié achetée
            if($facture->getAchats()[$i]->getCodeBar()==null)
            {
                $stock=$Stock->findOneBy(array("produit"=>$facture->getAchats()[$i]->getProduit(), "shop"=> $this->getShop()));
                // ===== on vérifie si on peut accéder au stock; si tel n'esét pas le cas on lance une exception qui arrete le script
                 if($stock!==null)
                {
                    $stock->augmenter($facture->getAchats()[$i]->getQuantite());
                    $em->persist($stock);
                }else
                {throw new NotFoundHttpException("Stock du produit ".$facture->getAchats()[$i]->getProduit()." inexistant ou inaccessible");
              
                }
            }else
            {
              $facture->getAchats()[$i]->setQuantiteRestant($facture->getAchats()[$i]->getQuantite());
            }
       } 
    //On persiste la factue
       $em->persist($facture);
        
       //si la facture n'est pas payé on enregistre la dette
       /*if($facture->getPaye()==false)
       {
       $Dette=new DetteFacture();
       $Dette->setFacture($facture);
       $Dette->setDateEcheance(new \DateTime("+ 30 days"));
       $Dette->setMontant($facture->getTotal());
       $Dette->setShop($this->getShop())->setUser($this->getUser());
       $em->persist($Dette);
        // enregisterement des opérations en bdd
        
       } */
       $em->flush(); 
         $msg="Enregistrement de la facture réuissi. Achats effectués";
         $ProuitController= $this->get('go_shop.static_data_generator');
         $ProuitController->updateCodeBarFile();
         
      return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
        
}
/**
     * 
     * @param FactureAchat $facture
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Route("facture/delete/{id}", name="delete_facture_achat")
     * 
     */
    public function deleteFactureAction(FactureAchat $facture, Request $req)
    {
             $msg=null;$errorMsg=null;
           $em=$this->em();
            foreach($facture->getAchats() as $achat)
                {
                $Stock=$this->getStock($achat->getProduit());
                $Stock->setQuantite($achat->getQuantite()-$Stock->getQuantite());
                $em->persist($Stock);
                $em->remove($achat);
                } 
                if($facture->getPaye()==false)
                    $detteFact=$this->getRepo('DetteFacture')->findByFacture($facture);
                    if(!empty($detteFact))
                       $em->remove($detteFact[0]); 
                $em->remove($facture);
                try {
                   $em->flush();
                   $msg="Facture  Supprimée avec succès!";
                   
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
                 return $this->factureShowListeAction($req);
            
        }
/**
     * 
     * @param Achat $achat
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("/delete/{id}", name="delete_achat")
     * 
     */
    public function deleteAction(Achat $achat, Request $req)
    {
             $msg=null;
            $errorMsg=null;
            
                $em=$this->em();
                $Stock=$this->getStock($achat->getProduit());
                $Stock->setQuantite($Stock->getQuantite()-$achat->getQuantite());
                $em->persist($Stock);
                $em->remove($achat);
                try {
                   $em->flush();
                   $msg="Achat annulée avec succès!";
                   
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
                 return $this->sendResponse(array(
               "view"=>'GOShopBundle:Achat:index.html.twig',
               "msg"=>$msg,
             "errorMsg"=>$errorMsg
               //"responseVars"=> array('form'=>$resForm->createView()
                ));
            
        }
        //==========================LES METHODES DE RECUPERATIONS ET DAFFICHAGE DE DONNEES ==================
    public function showTodayAction(Request $req)
    {      $shop=$this->getShop();
            $achatRepo=$this->getRepo('FactureAchat');
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::AUJOURDHUI);
           return $this->render('GOShopBundle:Achat:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
     }
    public function factureShowListeAction(Request $req)
    {
           $shop=$this->getShop();
            $achatRepo=$this->getRepo('FactureAchat');
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::MOIS);
           return $this->render('GOShopBundle:Achat:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
        }
    public function factureShowAction(FactureAchat $facture, Request $req)
    {
           
           return $this->render('GOShopBundle:Achat:fact_show.html.twig', array('facture'=>$facture));
        }
    public function showSearchIndexAction()
    {
        $data = array();
                $form = $this->createForm(new AchatSearchType(),$data);
         return $this->render('GOShopBundle:Achat:search_index.html.twig', 
                array('form'=>$form->createView()));
    }
    public function searchAction(Request $req)
    {
        $clientRepo=$this->getRepo('Client');
        $achatRepo=$this->getRepo('Achat');
        $liste= null;
        $achats=null;
        $total_achat=null;
        $form=$this->createForm(new AchatSearchType(), array());
        $form->bind($req);
        $shop= $this->getShop();
        if($form->isValid())
        {
            
        $data=$form->getData();
        //var_dump($data);
        switch ($data['type_search'])
        {
            case 'total_achat': $total_achat=$achatRepo->getTotalAchat($shop,Cons::DATE_INTERVALLE,'', $data['date_debut'], $data['date_fin']);
                break;
            case 'liste_achat': $achats=$achatRepo->getListeAchat($shop,Cons::DATE_INTERVALLE,'', $data['date_debut'], $data['date_fin']);
                break;
            case 'total_achat': $total_achat=$achatRepo->getTotalAchat($shop,Cons::DATE_INTERVALLE,'', $data['date_debut'], $data['date_fin']);
                break;
            case 'liste_fac': $achatRepo=$this->getRepo('FactureAchat'); 
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::DATE_INTERVALLE, FactureAbstract::FACTURE_PAYE_ET_NON_PAYE, $data['date_debut'], $data['date_fin']);
           return $this->render('GOShopBundle:Achat:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
            break;
            case 'liste_fac_non_paye': $achatRepo=$this->getRepo('FactureAchat'); 
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::DATE_INTERVALLE, FactureAbstract::FACTURE_NON_PAYE, $data['date_debut'], $data['date_fin']);
           return $this->render('GOShopBundle:Achat:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
            break;
            case 'liste_fac_paye': $achatRepo=$this->getRepo('FactureAchat'); 
           $liste_factures= $achatRepo->getListeFactures($shop,Cons::DATE_INTERVALLE, FactureAbstract::FACTURE_PAYE, $data['date_debut'], $data['date_fin']);
           return $this->render('GOShopBundle:Achat:fact_liste.html.twig', array('liste_factures'=>$liste_factures));
            break;
            
        }
        
            }
           
        return $this->render('GOShopBundle:Achat:search_result.html.twig', array('achats'=>$achats, 'total_achat'=>$total_achat));
        
    }
    
    /**
     * 
     * @param \GO\ShopBundle\Controller\Facture $facture
     * @param Request $req
     * @Route("facture/{id}/add_produit", name="facture_add_produit")
     */
   public function addProduitOnFactureAction(FactureAchat $facture, Request $req)
   {
       $achat = new Achat();
       $achat->setFacture($facture);
       $factureForm= $this->createForm(new AchatType(), $achat);
       if($req->getMethod()=="POST")
       {
            $factureForm->handleRequest($req);
            //$achat->setShop($this->getShop());
            //$achat->setUser($this->getUser());
            $achat->setDate(new \DateTime());
            $achat->setLastUpdate(new \DateTime());
            $achat->setPaye($facture->getPaye());
            if($factureForm->isValid())
            {
               
                $em= $this->em();
                $em->persist($achat);
                $em->flush();
                //si le produit acheté n'a pas de code barre, on prend le code barre par défaut 
            if($achat->getCodeBar()==null)
            {
                $achat->setCodeBar($achat->getProduit()->getDefaultCodeBar()); 
                
            }  
              $achat->setQuantiteRestant($achat->getQuantite());
            
              $em->persist($achat);
              $em->flush();
            return $this->sendResponse(array('msg'=>'Produit ajouté  avec succès!'));
            }else
            {
                return $this->render('@GOShop/Achat/_new.html.twig', array('form'=>$factureForm->createView(),"facture"=>$facture));
            }
       }else
       {
           return $this->render('@GOShop/Achat/_new.html.twig',array('form'=>$factureForm->createView(),"facture"=>$facture));
       }
       
       
   }
   /**
    * 
    * @param FactureAchat $facture
    * @param Request $req
    * @Route("/facture/{id}/regler", name="regler_facture_achat")
    */
   public function reglerFactureAction(FactureAchat $facture, Request $req)
   {
       $facture->setPaye(true);
       $em= $this->em();
       $em->persist($facture);
       $em->flush();
       $this->addFlash("success", "Facture marquée comme étant réglée!");
       return $this->render("@GOShop/Achat/achat_main_layout.html.twig");
   }
   /**
    * 
    * @param FactureAchat $facture
    * @param Request $req
    * @Route("/facture/{id}/details/{format}", name="details_facture_achat", defaults={"format"="jason"}, options = { "expose" = true })
    */
   public function detailsFactureAction(FactureAchat $facture, Request $req)
   {
       $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($facture, 'json');

// $jsonContent contains {"name":"foo","age":99,"sportsperson":false,"createdAt":null}

        //echo $jsonContent;
       return new Response($jsonContent);
   }

}
