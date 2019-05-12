<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\FatalErrorException;
use GO\ShopBundle\Entity\Produit;
use GO\ShopBundle\Entity\Achat;
use GO\ShopBundle\Entity\Stock;
use GO\ShopBundle\Entity\Inventaire;
use GO\ShopBundle\Entity\InventaireRepository as InvRepo;
use GO\ShopBundle\Entity\ProduitInventaire;
use GO\ShopBundle\Entity\AchatRepository;
use GO\ShopBundle\Entity as GOShopEntity;
use GO\ShopBundle\Form\StockEditType;
use GO\ShopBundle\Form\InventaireType;
use GO\ShopBundle\Form\ProduitInventaireType;
use GO\ShopBundle\Utils\CustomValidator as Validator;
use GO\ShopBundle\Utils\Constants as Cons;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;
use GO\GOLibrary\HTTP\AjaxJsonResponse;
use Symfony\Component\Form\FormError;
class StockController extends MainController{
    //put your code here
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("stock_index.golob", name="stock_index")
     */
    public function indexAction(Request $req) {
        $Stock=$this->getRepo('Stock')->getEtatStock($this->getShop());
        return $this->render('GOShopBundle:Stock:index.html.twig', array("stocks"=>$Stock));
   
        //var_dump($Stock);die();
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("stock_produits_show.golob", name="stock_produits")
     */
     public function showListeAction(Request $req) {
        $Stock=$this->getRepo('Stock')->findByShop($this->getShop());
        return $this->render('GOShopBundle:Stock:liste.html.twig', array("produits"=>$Stock));
   
        //var_dump($Stock);die();
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_update-{id}.golob", name="stock_update")
     * 
     */
     public function updateAction(Stock $stock,Request $req) {
        //ar_dump($req->getSession()->get('connected_shop'));
        if(!$req->getSession()->has('connected_shop'))
        {
            throw new FatalErrorException("La boutique renseignée est différente de celle trouvée dans la requette");
        }
       $form= $this->createForm(new StockEditType(), $stock);
       $form->bind($req);
       if($form->isValid())
       {
       $em= $this->em();
        $em->persist($stock);
        $em->flush();
        $msg="Stock du produit ".$stock->getProduit()->getNom()." modifié avec succès!";
        return $this->sendResponse(array("msg"=>$msg));
       }else
           return $this->render('GOShopBundle:Stock:_form.html.twig', array('form'=>$form->createView()));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_update_form-{id}.golob", name="stock_update_form")
     */
     
    public function updateFormAction(Stock $stock, Request $req)
    {
        $form= $this->createForm(new StockEditType(), $stock);
        return $this->render('GOShopBundle:Stock:_form.html.twig', array('form'=>$form->createView()));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire_index.golob", name="stock_inventaire_index")
     */
     
    public function inventaireIndexAction(Request $req)
    {
        $Inventaire=new Inventaire();
        $form= $this->createForm(new InventaireType(), $Inventaire);
        return $this->render('GOShopBundle:Stock:_inventaire_form.html.twig', array('form'=>$form->createView()));
    }
     
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire-{id}_add_produit.golob", name="stock_inventaire_add_produits")
     */
     
    public function produitInventaireFormAction(Inventaire $inventaire, Request $req)
    {
        $ProduitInventaire=new ProduitInventaire();
        $Inventaire=new Inventaire();
        //$form= $this->createForm(new ProduitInventaireType(), $ProduitInventaire);
        $form= $this->createForm(new InventaireType(), $inventaire);
        //return $this->render('GOShopBundle:Stock:_ajouter_produit_inventaire_form.html.twig', array('inventaire'=>$inventaire,'form'=>$form->createView()));
        return $this->render('GOShopBundle:Stock:_ajouter_produit_inventaire_form.html.twig', array('inventaire'=>$inventaire,'form'=>$form->createView()));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("add_produit_to_inventaire-{id}.golob", name="stock_ajouter_produit_inventaire")
     */
     
    public function produitInventaireAddMultipleAction(Inventaire $inventaire, Request $req)
    {
        $em= $this->em();
        $InventaireUpdated=new Inventaire();
        $form= $this->createForm(new InventaireType(), $InventaireUpdated);
        $form->bind($req);
        if($form->isValid())
        {
         foreach($InventaireUpdated->getProduits()->getIterator() as $i=>$object)
        {
        $InventaireUpdated->getProduits()[$i]->setInventaire($inventaire);
        $InventaireUpdated->getProduits()[$i]->setDateEntree(new \DateTime());
        
        // récupérer le stock du produit pour remplir le prix virtuel
        $stock= $this->getStock($InventaireUpdated->getProduits()[$i]->getProduit());
        $InventaireUpdated->getProduits()[$i]->setStockVirtuel($stock->getQuantite());
        // si le prix achat n'est pas renseigné, on récupére celui enregistré avec l'objet produit,
        //sinon on garde les données envoyées par le formulaire
        
        if($InventaireUpdated->getProduits()[$i]->getCodeBar()!=null)
        {
            $achat= $this->getRepo('Achat')->findByCodeBar($this->getShop(),$InventaireUpdated->getProduits()[$i]->getCodeBar());
            $achat->getPrixUnit();
        }
        
        if($InventaireUpdated->getProduits()[$i]->getPrixAchat()==null)
        {
        $InventaireUpdated->getProduits()[$i]->setPrixAchat($InventaireUpdated->getProduits()[$i]->getProduit()->getPrixAchat());
        }
        $em->persist($InventaireUpdated->getProduits()[$i]);
        
        
        }
        //var_dump($InventaireUpdated->getProduits()[$i]->getInventaire());die();
        //On persiste l'a factue'objet inventaire
      // $em->persist($InventaireUpdated);
        $em->flush();
        
       // if($this->save($ProduitInventaire))
        $msg="entrée enregistrée!";
        return $this->sendResponse(array('msg'=>$msg));
        } else {
            return $this->sendResponse(array('errorMsg'=>"Formulaire non valide!"));
        }
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire_save_draft.golob", name="stock_inventaire_save_draft")
     */
     
    public function inventaireSaveDrafAction(Request $req)
    {
        $Inventaire=new Inventaire();
        $form= $this->createForm(new InventaireType(), $Inventaire);
        $form->bind($req);
        $Inventaire->setUser($this->getUser())->setShop($this->getShop());
        
        if($form->isValid())
        {
            $em= $this->em();
            $em->persist($Inventaire);
            $em->flush();
            $msg="Inventaire souvegardé avec succès!";
            return $this->sendResponse(array("msg"=>$msg));
        }
        return $this->render('GOShopBundle:Stock:_inventaire_form.html.twig', array('form'=>$form->createView()));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire_liste.golob", name="stock_inventaire_liste")
     */
     
    public function inventaireShowAction(Request $req)
    {
        $inventaires= $this->getRepo('Inventaire')->getListeInventaire($this->getShop());
        return $this->render('GOShopBundle:Stock:inventaire_liste.html.twig', array('inventaires'=>$inventaires));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock/inventaire/{id}/produits", name="stock_inventaire_liste_produits")
     */
    
    public function inventaireShowProduitsAction(Inventaire $inventaire,Request $req)
    {
        $ProduitInventaire=new ProduitInventaire;
        $form= $this->createForm(ProduitInventaireType::class,$ProduitInventaire, array("method"=>"POST"))
                ->remove("codeBar");
        $produits_inventaire= $this->getRepo('Inventaire')->getProduits($inventaire, InvRepo::PRODUITS_FIND_ALL);
        return $this->render('GOShopBundle:Stock:inventaire_produits.html.twig', array('inventaire'=>$inventaire, "produits_inventaire"=>$produits_inventaire, "form"=>$form->createView()));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire_resultat-{id}.golob", name="stock_inventaire_resultat")
     */
     
    public function inventaireGetResultatAction(Inventaire $inventaire,Request $req)
    {
        $invRepo= $this->getRepo('Inventaire');
        $pInvRepo= $this->getRepo('ProduitInventaire');
       return $this->render('GOShopBundle:Stock:inventaire_result.html.twig', 
               array('inventaire'=>$inventaire,
                    'produits_deficit'=>$invRepo->getProduitsDeficit($inventaire),
                    'produits_surplus'=>$invRepo->getProduitsSurPlus($inventaire),
                    'produits_absents'=>$pInvRepo->getProduits($inventaire, InvRepo::PRODUITS_NON_INVENTE),
                    'produits_absentsCodeBar'=>$pInvRepo->getProduits($inventaire, InvRepo::PRODUITS_TYPE)
               ));
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire_export-{id}.golob", name="stock_inventaire_export")
     */
     
    public function inventaireExportAction(Inventaire $inventaire,Request $req)
    {
        $inventaire->setCaisse($this->getCaisse()->getSolde());
        $venteRepo=$this->getRepo('Vente');
        $depenseRepo=$this->getRepo('Sortie');
        //========Créances================
        $creanceProduitRepo=$this->getRepo('CreanceProduit');
        $creanceLiquideRepo=$this->getRepo('CreanceLiquide');
        //=================dette==========
        $detteFactureRepo=$this->getRepo('DetteFacture');
        $detteLiquideRepo=$this->getRepo('DetteLiquide');
        //=================Vente=================
        $total_vente=$venteRepo->getTotalVente($this->getShop(),Cons::DATE_INTERVALLE,'', $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
        $total_benef_vente=$venteRepo->getTotalBenefice($this->getShop(),Cons::DATE_INTERVALLE,'', $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
        $total_depense=$depenseRepo->getTotalDepense($this->getShop(),Cons::DATE_INTERVALLE, $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
       
        $inventaire->setVente($total_vente);
         $inventaire->setBeneficeVente($total_benef_vente);
         $inventaire->setDepense($total_depense);
         $inventaire->setCreanceProduit($creanceProduitRepo->getTotalCreancesNonRemb($this->getShop()));
         $inventaire->setCreanceLiquide($creanceLiquideRepo->getTotalCreancesNonRemb($this->getShop()));
         $inventaire->setDetteLiquide($detteLiquideRepo->getTotalDetteNonRemb($this->getShop()));
         $inventaire->setDetteProduit($detteFactureRepo->getTotalDetteNonRemb($this->getShop()));
         if($em->save($inventaire))
         {
        return $this->render('GOShopBundle:Stock:inventaire_result.html.twig', array('inventaire'=>$inventaire));
         }else
         {
             $this->sendResponse(array('errorMsg'=>"Une erreur s'est produite. Les données ne sont pas enregistrées!"));
         }
    }
     /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUP_BOUT")
     * @Route("stock_inventaire/{id}/process", name="stock_inventaire_process")
     */
     
    public function inventaireProcessAction(Inventaire $inventaire,Request $req)
    {
        $inventaire->setCaisse($this->getCaisse()->getSolde());
        $inventaire->setCapital($this->getRepo('Capital')->findOneByShop($this->getShop()->getId())->getMontant());
         $venteRepo=$this->getRepo('Vente');
        $depenseRepo=$this->getRepo('Sortie');
        //========Créances================
        $creanceProduitRepo=$this->getRepo('CreanceProduit');
        $creanceLiquideRepo=$this->getRepo('CreanceLiquide');
        //=================dette==========
        $detteFactureRepo=$this->getRepo('DetteFacture');
        $detteLiquideRepo=$this->getRepo('DetteLiquide');
        //=================Vente=================
        $total_vente=$venteRepo->getTotalVente($this->getShop(),Cons::DATE_INTERVALLE,'', $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
        $total_benef_vente=$venteRepo->getTotalBenefice($this->getShop(),Cons::DATE_INTERVALLE,'', $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
        $total_depense=$depenseRepo->getTotalDepense($this->getShop(),Cons::DATE_INTERVALLE, $inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode());
       
        $inventaire->setVente($total_vente);
         $inventaire->setBeneficeVente($total_benef_vente);
         $inventaire->setDepense($total_depense);
         $inventaire->setCreanceProduit($this->getRepo('FactureAchat')->getTotalFacture($this->getShop(),Cons::DATE_INTERVALLE, \GO\ShopBundle\Entity\FactureAbstract::FACTURE_NON_PAYE,$inventaire->getDateDebutPeriode(),$inventaire->getDateFinPeriode()));
         $inventaire->setCreanceLiquide($creanceLiquideRepo->getTotalCreance($this->getShop(),["dateDebut"=>$inventaire->getDateDebutPeriode(),"dateFin"=>$inventaire->getDateFinPeriode()]));
         $inventaire->setDetteLiquide($detteLiquideRepo->getTotalDetteNonRemb($this->getShop()));
         $inventaire->setDetteProduit($detteFactureRepo->getTotalDetteNonRemb($this->getShop()));
         $inventaire->setValeurBoutiquePrecedent($inventaire->getInventairePrecedent()->getValeurBoutique());
         $inventaire->setStockReelPrecedent($inventaire->getInventairePrecedent()->getValeurStockReel());
         $inventaire->setTermine(true);
         if($this->save($inventaire))
         {
        return $this->redirectToRoute("stock_inventaire_resultat", array('id'=>$inventaire->getId()));
         }else
         {
             $this->sendResponse(array('errorMsg'=>"Une erreur s'est produite. Les données ne sont pas enregistrées!"));
         }
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Route("stock_inventaire/{id}/reset_all", name="stock_inventaire_reset")
     */
    public function resetStockAction(Inventaire $inventaire, Request $req)
    {
        $em= $this->em();
     //Vérifie que la boutique à laquelle appartient l'inventaire est la même que celle à laquelle l'utilisateur est actuellement connecté
        if($inventaire->getShop()->getId()===$this->getShop()->getId())
        {
        $stockRepo= $this->getRepo('Stock');
        //On remet le stock à zero
        $result=$this->resetStockAll();
        if($result!==false)
        {
            //On récupère les produits dans l'inventaire
          $produits= $this->em()->createQuery('SELECT pi FROM GO\ShopBundle\Entity\ProduitInventaire pi where pi.inventaire=:inventaire')->setParameter('inventaire', $inventaire);
         
          //le batch permet d'effectuer des actions multiples sans problème de mémoire
          $batchSize = 20;
            $i = 0;
            $iterableResult = $produits->iterate();
            foreach ($iterableResult as $row) {
                $stock_inventaire= $row[0];
                $stock=$stockRepo->findOneBy(array('produit'=>$stock_inventaire->getProduit(), "shop"=> $this->getShop()));
                if(!empty($stock))
                {
                $stock->setQuantite($stock_inventaire->getStockReel());
                $em->persist($stock);
                }else
                {}
                if (($i % $batchSize) === 0) {
                    $em->flush(); // Executes all updates.
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                ++$i;
            }
            //on récupère toutes les ventes qui sont effectués après la période de fin de l'inventaire afin de réduire le stock selon la quantité vendue
            $produits_vendus= $this->em()->createQuery('SELECT v FROM GO\ShopBundle\Entity\Vente v where DATE(v.date)>:date_processed AND v.shop=:shop')->setParameter('date_processed', $inventaire->getDateFinPeriode())->setParameter('shop', $this->getShop());
            $batchSize = 20;
            $i = 0;
            //On parcourt toutes les ventes et on effectue les modifications 
            $iterableResult = $produits_vendus->iterate();
            foreach ($iterableResult as $row) {
                $vente= $row[0];
                //On récupère le stock du produit
               $stock=$this->getStock($vente->getProduit());
              if(!empty($stock)&&$stock!=null)
                {
                $stock->diminuer($vente->getQuantite());
                $em->persist($stock);
                }else
                {}
                if (($i % $batchSize) === 0) {
                    $em->flush(); // Executes all updates.
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                ++$i;
            }
            //on récupère toutes les ventes qui sont effectués après la période de fin de l'inventaire afin d'augmenter le stock selon la quantité vendue
            $produits_achetes= $this->getRepo('Achat')
                    ->createQueryBuilder('a')
                    ->join('a.facture','f')
                    ->where('f.shop=:shop')
                    ->andWhere('DATE(a.date)>:date_processed')
                    //On doit uniquement les produits dans code Barre
                    ->andWhere('a.codeBar IS NULL')
                    ->setParameter('date_processed', $inventaire->getDateFinPeriode())
                    ->setParameter('shop', $this->getShop());
            $batchSize = 20;
            $i = 0;
            $iterableResult = $produits_achetes->getQuery()->iterate();
            foreach ($iterableResult as $row) {
                $achat= $row[0];
                if($achat instanceof Achat)
                {
               $stock=$this->getStock($achat->getProduit());
              if(!empty($stock))
                {
                    $stock->augmenter($achat->getQuantite());
                    $em->persist($stock);

                    if (($i % $batchSize) === 0) {
                        $em->flush(); // Executes all updates.
                        $em->clear(); // Detaches all objects from Doctrine!
                    }
                ++$i;
                }
                
                }else
                {
                    throw new \Exception("Type Achat attendu! Un autre type renseigné");
                }
            }
            $em->flush();
            return $this->render("GOShopBundle:Produit:produit_main_layout.html.twig", array('msg'=>"Les modiifications ont été apportées avec succès!"));
        }
        
           }else
return new Response("Impossible de remettre les stocks des produits à zéro. Vérifiez si vous êtes autorisé à effectuer une telle opération.");
    }
    protected function resetStockAll()
    {
        //if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
        $em= $this->em();
        $q = $em->createQuery('update GO\ShopBundle\Entity\Stock s set s.quantite=0 where s.shop=:shop');
        $q->setParameter('shop', $this->getShop());
       return $q->execute();
        
         //return false;
        
    }
    /**
    
     * @param Inventaire $inventaire
     * @return type
     * @Route("stock/inventaire/{id}/reset_stock", name="_restet_stock_code_bar")
     */
    public function resetStockCodeBarAll(Inventaire $inventaire)
    {
//        ----- Etape 1 --------------
//Remettre tous les stocks code bar et non code barre à zero 0
        $this->resetStockAll();
        $em= $this->em();
        $q = $em->createQuery('update GO\ShopBundle\Entity\Achat a SET a.quantiteRestant=0 where a.facture IN (SELECT fa FROM GO\ShopBundle\Entity\FactureAchat fa WHERE fa.shop=:shop AND DATE(a.date)<:dateTo)');
        $q->setParameter('shop', $this->getShop());
        $q->setParameter('dateTo', $inventaire->getDateFinPeriode());
          $r=$q->execute();
//----- Etape 2 ---------------
//Récupérer tous les produits inventaires qui n'ont pas de stock code barre et créer une facture fictive afin qu'il dispose
//d'un stock code barre grace à leur code barre par defaut dont on se servira. La quantité sera celle du stock réel dans l'inventaire
 $factureAchat=(new GOShopEntity\FactureAchat)
                ->setFournisseur($this->getRepo('Fournisseur')->find(87))
                ->setAvance(0)
                ->setPaye(true)
                ->setDate(new \DateTime())
                ->setDateFacture(new \DateTime())
                ->setFraisTransport(0)
                ->setShop($this->getShop())
                ->setUser($this->getUser())
                ->setLivre(true) 
                ->setNum(Date('mdysi'));
                $produits=$inventaire->getProduits();
                $em->persist($factureAchat);
                foreach($produits as $produitInv)
                {
                  if(null==$produitInv->getCodeBar())
                   {
                    $produit=$produitInv->getProduit();
                    $achat=(new GOShopEntity\Achat)
                            ->setCodeBar($produit->getDefaultCodeBar())
                            ->setProduit($produit)
                            ->setLastUpdate(new \DateTime())
                            ->setPrixUnit($produit->getPrixAchat())
                            ->setPrixVente($produit->getPrixVente())
                            ->setQuantite($produitInv->getStockReel())
                            ->setQuantiteRestant($produitInv->getStockReel())
                            ->setPaye(true)
                            ->setFacture($factureAchat)
                            ->setDate(new \DateTime())
                            ;
                    $em->persist($achat);
//----- Etape 3 ----------------
////Après avoir crée un stock code barre pour les produits qui n'en avaient pas au paravent pas au paravent, on les affecte à entrée dans l'inventaire
//Ce qui fait que dans l'inventaire, désormais tous les produits ont un stock code barre

                    $produitInv->setCodeBar($achat);
                    $em->persist($produitInv);
                   }
                    
                }
                // flush de création des données 
                $em->flush();
        
        

//----- Etape 4 ---------------
//Modifier tous les stocks code barre avec leur vraie valeur dans l'inventaire
  $produits=$inventaire->getProduits();
        $batchSize = 20;
            $i = 0;
       foreach($produits as $produit)
        {
            $achat=$produit->getCodeBar();
            if($achat!=null)
            {
                $achat->setQuantiteRestant($produit->getStockReel());
                $achat->setLastUpdate(new \DateTime());
                $em->persist($achat);
                if (($i % $batchSize) === 0) {
                        $em->flush(); // Executes all updates.
                        //$em->clear(); // Detaches all objects from Doctrine!
                    }
            }
          
            ++$i;
        }
        $em->flush();
//----- Etape 5 ---------------
//Récupérer tous les achats après inventaire et augmentez leur stock respectif (vu qu'on avait remis tous les stock à zero)
/*
$em= $this->em();
        $achats= $this->getRepo('Achat')->createQueryBuilder('a')
                ->select('a')->where('DATE(a.date)>:date')
                ->andWhere('a.codeBar IS NULL')
                ->setParameter('date',$inventaire->getDateFinPeriode())
                ->getQuery()->getResult();*/
//----- Etape 6 ------------
//récupérer toutes les ventes effectuées après inventaire et réduire leur stock respectif
 //On récupère toutes les ventes effectuées après l'inventaire et on modifie les stocks respectifs
       // $ventes= $this->getRepo("Vente")->getListeVente($this->getShop(), Cons::DATE_INTERVALLE, null,$inventaire->getDateDebutPeriode());
        /*
        $batchSize=20;
        $i=0; 
         $ventes=$this->getRepo("Vente")->createQueryBuilder("v")
                                ->select('v')
                                ->where('v.codeBar IS NOT NULL')
                                ->andWhere('DATE(v.date)>:dateInventaire')
                                ->andWhere('v.shop=:shop')
                                ->setParameter('dateInventaire', $inventaire->getDateFinPeriode())
                                ->setParameter('shop', $this->getShop()->getId())
                                ->getQuery()->getResult();
        foreach ($ventes as $vente)
        {
            $achat=$vente->getCodeBar();
            
                
                $achat->setQuantiteRestant(intval(($achat->getQuantiteRestant()-$vente->getQuantite())));
                $achat->setLastUpdate(new \DateTime());
                $em->persist($achat);
                if (($i % $batchSize) === 0) {
                        $em->flush(); // Executes all updates.
                        //$em->clear(); // Detaches all objects from Doctrine!
                    }
            
            ++$i;
        }*/
//----- Etape 7 ------------
        
          
        
       
        return new Response("Stock Réinitialisé Avec Succès!");
         //return false;
        
    }
     /**
      * 
      * @param Request $req
      * @param Inventaire $inventaire
      * @Route("inventaire/{id}/add_single_product", name="inventaire_add_single_product")
      * @View(serializerEnableMaxDepthChecks=true)
        */
     
    public function addSingleProduct(Request $req, Inventaire $inventaire)
    {
        /* produit inventaire qui représente chaque entrée dans l'inventaire
         * Il rensigne le produit enregistré, la quantité réelle dans le stock physique et le prix de revient
         */
        //préparation de la réponse à envoyer aux utilisateurs 
            $response=new AjaxJsonResponse();
            
        $ProduitInventaire=new ProduitInventaire();
        $ProduitInventaire->setInventaire($inventaire);
        $formCodeBar = $this->createForm("GO\ShopBundle\Form\ProduitInventaireType", $ProduitInventaire);
        //le formulaire sera rendu deux façons différentes c'est pourquoi on le clone pour avoir deux formulaires distincts
        $formSimple = clone $formCodeBar;
        // le formulaire code de vente avec code barre ne doit pas avoir de champ "produit"
        $formCodeBar->remove('produit');
        // le formulaire code de vente sans  code barre ne doit pas avoir de champ "code barre"
      $formSimple->remove('codeBar');
        $formSimple->handleRequest($req);
        //====Traitement du formulaire pour une vente sans code barre====
        //Dans le cas d'une vente avec code barre, le forumalire est envoyé vers une autre methode
          
        if($formSimple->isSubmitted()&&$formSimple->isValid())
        {
            //On récupère les infos sur le stock du produit, ce dernier doit lever une exception s'il n'existe pas
            if(null!==$stock= $this->getStock($ProduitInventaire->getProduit()))
            {     
               $ProduitInventaire->setStockVirtuel($stock->getQuantite())
                                  ->setDateEntree(new \DateTime());
               try 
            {
                   //Persistence dans la base de données de l'objet Produit Inventaire
                   
            $this->save($ProduitInventaire);
            
            $responseParams=$response->createSuccessResponseArray(
                    sprintf("Produit %s Ajouté avec Succès",$ProduitInventaire->getProduit()->getNom()));
                    
            
             return $this->render("@GOShop/Stock/index.html.twig", $responseParams);
               } catch (\Exception $e)
               {
                   $responseParams=$response->createErrorResponseArray($e->getMessage(). " ligne:".$e->getLine());
             return $this->render("@GOShop/Stock/index.html.twig", $responseParams);
             
               }
            }else
            {
               // Response::
                return $this->createNotFoundException("Le stock du produit n'existe pas");
            }
        }
        
        // si le formulaire n'est pas valide on renvoie le meme formulaire avec les erreurs
        return $this->render('@GOShop/Stock/_add_single_produit.html.twig', array(
            "inventaire"=>$inventaire,'form'=>$formCodeBar->createView(),"formSimple"=>$formSimple->createView()
            
                ));
        
    }
     /**
      * 
      * @param Request $req
      * @param Inventaire $inventaire
      * @Method({"POST","PUT"})
      * @Route("inventaire/{id}/add_single_product/code_barre", name="inventaire_add_single_product_code_bar",options={"expose"=true})
      * @Route("inventaire/{id}/add_single_product/code_barre/{id_achat}",
      *  name="inventaire_add_single_product_code_bar_with_achat", options={"expose"=true} )
      * @ParamConverter("achat",options={"id"="id_achat"})
      */
    public function addSingleProductCodeBar(Request $req, Inventaire $inventaire, Achat $achat=null)
    {
        $response=new AjaxJsonResponse();
        //on récupère l'entité repo pour inventaire
        $InventaireRepo=$this->getRepo("Inventaire");
        $ProduitInventaire=new ProduitInventaire();
        $ProduitInventaire->setInventaire($inventaire);
        $formCodeBar = $this->createForm(ProduitInventaireType::class, $ProduitInventaire);
        $formSimple = $this->createForm(ProduitInventaireType::class, $ProduitInventaire);
        /*le formulaire est prévu pour envoyer des données à la fois sans ou avec code barre. Donc elle est adapté aux produits
        avec ou sans code barr */
        $formCodeBar->remove('produit');
        $formSimple->remove('codeBar');
        $formCodeBar->handleRequest($req);
        
        //Cette partie permet de prévoir le fait que plusieurs produits puissent avoir le même code barre. 
        //si un code barre est attribué à plusieurs produits, donc en doit en choisir un et le renseigner via l'argument "achat"
        //de la fonction, qui par défaut est défini à null, puisque le code barre n'est pas forcément renseigné.
        //Si il n'est pas renseigné, on en cherche un dans la base de données 
        if(null===$achat)
        {
        if(null==$achat=$this->getRepo('Achat')->findByCodeBar($this->getShop(),$ProduitInventaire->getCodeBar()))
            {
            $responseParams=$response->createErrorResponseArray("Code Barre Introuvable !", Response::HTTP_NOT_FOUND);
            return $this->render("@GOShop/layout.html.twig",$responseParams);
            
            }
        }
        if($InventaireRepo->isAchatInInventaire($this->getShop(),$inventaire, $achat))
        {
           $responseParams=$response->createErrorResponseArray("Ce produit avec ce code barre est déjà enregistré", Response::HTTP_NOT_FOUND);
           
           //return $this->render("@GOShop/layout.html.twig",$responseParams);
        }
        
        if($formCodeBar->isSubmitted() && $formCodeBar->isValid())
        {
            $ProduitInventaire
                    ->setPrixAchat($achat->getPrixUnit())
                    ->setPrixVente($achat->getPrixVente())
                    ->setProduit($achat->getProduit())
                    ->setStockVirtuel($achat->getQuantiteRestant())
                    ->setDateEntree(new \DateTime())
                    ->setCodeBar($achat);
            
           $this->save($ProduitInventaire);
           $responseParams=$response->createSuccessResponseArray("Produit ".$ProduitInventaire->getProduit()." Ajouté Avec Succès!");
           
            $responseFinal= new Response(json_encode($responseParams)); 
           $responseFinal->headers->set('Content-Type','application/js');
           return $responseFinal;
             /* $responseParams=$response->createSuccessResponseArray("Produit ".$ProduitInventaire->getProduit()." Ajouté Avec Succès!");
            return $this->render("@GOShop/layout.html.twig",$responseParams);
              
              */
            
        }
        
        return $this->render('@GOShop/Stock/_add_single_produit.html.twig', array("inventaire"=>$inventaire,
           'form'=>$formCodeBar->createView(),'formSimple'=>$formSimple->createView()
            
                ));
                
        
    }
    
    //Fonction pour mettre à ajour un produit inventaire déjà enregistré
    /**
     * @Route("inventaire/{id}/update", name="inventaire_update")
     */
    public function updateInventaire(Request $req, Inventaire $inventaire)
    {
        $response=new AjaxJsonResponse();
        $form= $this->createForm(InventaireType::class,$inventaire, array("method"=>"POST","action"=>$this->generateUrl("inventaire_update",["id"=>$inventaire->getId()])))
               ->handleRequest($req);
        if($req->getMethod()=="POST"&&$form->isSubmitted()&&$form->isValid())
        {
            try
            {
            $this->save($inventaire);
            $serializer= $this->get('jms_serializer');
            $responseParams=$response->createSuccessResponseArray("Entrée modifiée avec succès!",Response::HTTP_OK);
            return $this->redirectToRoute("stock_inventaire_liste");
                    
            } catch (\Exception $e)
            {
                exit($e->getMessage());
            $responseParams=$response->createErrorResponseArray($e->getMessage());
            return $this->render('@GOShop/Stock/_form.html.twig', $responseParams);
             
            }
        }
        return $this->render('@GOShop/Stock/_inventaire_form.html.twig', array("form"=>$form->createView()));
        
        
    }
    //Fonction pour mettre à ajour un produit inventaire déjà enregistré
    /**
     * @Route("inventaire/produit_inventaire/{id}/update", name="produit_inventaire_update")
     */
    public function updateProduitInventaire(Request $req, ProduitInventaire $ProduitInventaire)
    {
        $response=new AjaxJsonResponse();
        $form= $this->createForm(ProduitInventaireType::class,$ProduitInventaire, array("method"=>"POST","action"=>$this->generateUrl("produit_inventaire_update",["id"=>$ProduitInventaire->getId()])))
                ->remove("codeBar")
               ->handleRequest($req);
        if($req->getMethod()=="POST"&&$form->isSubmitted()&&$form->isValid())
        {
            try
            {
            $this->save($ProduitInventaire);
            $serializer= $this->get('jms_serializer');
            $responseParams=$response->createSuccessResponseArray("Entrée modifiée avec succès!",Response::HTTP_OK,
            json_decode($serializer->serialize($ProduitInventaire,'json', SerializationContext::create()->enableMaxDepthChecks())));
            return $this->redirectToRoute("stock_inventaire_liste_produits", ["id"=>$ProduitInventaire->getInventaire()->getId()]);
                    $this->render('@GOShop/Stock/show.html.twig', $responseParams);
            } catch (\Exception $e)
            {
                exit($e->getMessage());
            $responseParams=$response->createErrorResponseArray($e->getMessage());
            return $this->render('@GOShop/Stock/_form.html.twig', $responseParams);
             
            }
        }
        return $this->render('@GOShop/Stock/_form.html.twig', array("form"=>$form->createView()));
        
        
    }
    //Fonction pour supprimer un produit inventaire déjà enregistré
    /**
     * @Route("inventaire/produit_inventaire/{id}/delete", name="produit_inventaire_delete")
     
     */
    public function deleteProduitInventaire(Request $req, ProduitInventaire $ProduitInventaire)
    {
        $response=new AjaxJsonResponse();
        $form= $this->createForm(ProduitInventaireType::class,$ProduitInventaire, array("method"=>"POST","action"=>$this->generateUrl("produit_inventaire_update",["id"=>$ProduitInventaire->getId()])))
                ->remove("codeBar")
               ->handleRequest($req);
        
            try
            {
            $this->delete($ProduitInventaire);
            $this->addFlash("success","Entrée supprimée avec succès!");
            
             return $this->redirectToRoute("stock_inventaire_liste_produits", ["id"=>$ProduitInventaire->getInventaire()->getId()]);
                   
            } catch (\Exception $e)
            {
                
            $responseParams=$response->createErrorResponseArray($e->getMessage());
            return $this->render('@GOShop/Stock/_form.html.twig', $responseParams);
             
            }
        
        return $this->render('@GOShop/Stock/_form.html.twig', array("form"=>$form->createView()));
        
        
    }
    /**
     * Cette fonction permet d'afficher l'historique d'un stock avec les entrées et les sorties de stock, 
     * c'est à dire les ventes et les achats
     * 
     * @param Request $req
     * @param Achat $achat
     * @param type $codeBar
     * @Route("/stock/get_historique", name="historique_stock_" )
     * @Route("/stock/get_historique/{id}", name="historique_stock_achat" )
     * @Route("/stock/get_historique/code_bar/{codeBar}", name="historique_stock_code_bar" )
     */
    public function getStockHistory(Request $req, Achat $achat=null, $codeBar)
    {
        
         $achatRepo= $this->getRepo("Achat"); 
        $achat= $this->getRepo("Achat")->findOneByCodeBar($codeBar);
        //$codeBar=$achat[0]->getCodeBar();
        
        //on vérifie s'il s'agit d'un code barre
        //On vérifie si les dates de début et de fin sont renseignées
        //
        //On récupère l'ensemble des achat (entrées) de stock
        $entrees=$achatRepo->getEntrees($this->getShop(),$codeBar);
        //On récupère l'ensemble des ventes effectués sur le stock
        $sorties=$achatRepo->getSorties($this->getShop(),$achat);
      $totauxSortie=array(
          "totalNombre"=>$achatRepo->getSorties($this->getShop(),$achat, AchatRepository::ACHAT_SORTIE_STOCK_NOMBRE_DE_FOIS),
          "totalQuantite"=>$achatRepo->getSorties($this->getShop(),$achat, AchatRepository::ACHAT_SORTIE_STOCK_QUANTITE_TOTAL),
          "totalValeurSortie"=>$achatRepo->getSorties($this->getShop(),$achat, AchatRepository::ACHAT_SORTIE_STOCK_TOTAL_VALEUR),
             
          );
      $totauxEntree=array(
          "totalNombre"=>$achatRepo->getEntrees($this->getShop(),$codeBar, AchatRepository::ACHAT_ENTREE_STOCK_NOMBRE_DE_FOIS),
          "totalQuantite"=>$achatRepo->getEntrees($this->getShop(),$codeBar, AchatRepository::ACHAT_ENTREE_STOCK_QUANTITE_TOTAL),
          "totalValeurEntree"=>$achatRepo->getEntrees($this->getShop(),$codeBar, AchatRepository::ACHAT_ENTREE_STOCK_TOTAL_VALEUR),
             
          );
      $params=array(
          "sorties"=>$sorties,
          "totauxSortie"=>$totauxSortie,
          "totauxEntree"=>$totauxEntree,
          "entrees"=>$entrees,
          "codeBar"=>$codeBar);
        return $this->render("@GOShop/Stock/historique_stock.html.twig",$params);
        //on récupère aussi les modifications manuelles subies par le stock
    }
    /**
     * @param Request $req
     * @Route("stock/code_bar/search", name="code_bar_search")
     */
    public function codeBarSearchAction(Request $req)
    {
        $requestData=[];
       $codeBarSearchForm= $this->createForm(\GO\ShopBundle\Form\CodeBarSearchType::class, $requestData, ["action"=> $this->generateUrl("code_bar_search")]); 
       $codeBarSearchForm->handleRequest($req);
       if($codeBarSearchForm->isSubmitted()&&$codeBarSearchForm->isValid())
       {
         $data=$codeBarSearchForm->getData();
         if(null!=$this->getRepo('Achat')->findByCodeBar($this->getShop(),$data["codeBar"]))
         {
         return $this->redirectToRoute("historique_stock_code_bar",["codeBar"=>$data["codeBar"]]);
         }else
         {$codeBarSearchForm->get('codeBar')->addError(new FormError('Le code barre est introuvable!'));
         }
       }
       
       return $this->render('@GOShop/Stock/_code_bar_search_form.html.twig',["form"=>$codeBarSearchForm->createView()]);
    }
}
