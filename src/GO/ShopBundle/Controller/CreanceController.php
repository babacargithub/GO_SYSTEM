<?php
namespace GO\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Form\CreanceProduitType;
use GO\ShopBundle\Form\CreanceLiquideType;
use GO\ShopBundle\Entity\CreanceProduit;
use GO\ShopBundle\Entity\CreanceLiquide;
use GO\ShopBundle\Entity\RembCreanceLiquide;
use GO\ShopBundle\Entity\RembCreanceProduit;
use GO\ShopBundle\Entity\Fournisseur;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
/**
 * Description of AchatController
 *
 * @author hp
 */
class CreanceController extends MainController {
    
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Enregistrer nouvelle", "id"=>"", "href"=>"creance_index.golob"),
           array("libelle"=>"Enregistrer Liquide", "id"=>"", "href"=>"creance_liquide_index.golob"),
             array("libelle"=>"Liste Créances", "id"=>"", "href"=>"#", 
                 "dropdown"=>array(
                                array("libelle"=>"Créances Produit", "id"=>"", "href"=>"creance_show.golob"),
                                array("libelle"=>"Créances Liquide", "id"=>"", "href"=>"creance_liquide_show.golob"),
                          )
               
               ),
           array("libelle"=>"Recherche", "id"=>"", "href"=>"produit_search_index.golob"),
          array("libelle"=>"Plus", "id"=>"", "href"=>"#")
           );
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * 
     * @param CreanceProduit $creance
     * @param Request $req
     * @return Response
     * @Route("creance_remb-{id}-{montant}.golob", defaults={"montant"=0}, name="creance_rembourser")
    
     */
    public function rembAction(CreanceProduit $creance,Request $req)
    {
        $Remb=new RembCreanceProduit();
        $CreanceNew=$creance;
         $Remb->setShop($this->getShop())->setUser($this->getUser());
         $Remb->setCreance($creance);
         $Remb->setMontant($req->get('montant'));
         // vérifie si le montant remboursé et supérieur ou égal à la somme totale de la créance, si oui on marque
         //la créance comme remboursée pour qu'elle n'apparaisse plus dans la liste des créances non payées
         $em=$this->em();
         if($Remb->getMontant()>$CreanceNew->getTotalRestant())
         {
             $CreanceNew->setRembourse(true);//$em->persist($CreanceNew);
             return $this->sendResponse(array('msg'=>"Créance Remboursé. Mais Le montant renseigné est supérieur au montant restant de la créance"));
         }if($Remb->getMontant()>=$CreanceNew->getTotal())
         {
             $CreanceNew->setRembourse(true);//$em->persist($CreanceNew);
         }
           // $CreanceNew->setRembourse(true);
            $em->persist($CreanceNew);
            //======Versement à la caisse
            $Caisse=$this->getCaisse();
            $Caisse->ajouter($Remb->getMontant());
            $em->persist($Caisse);
            $em->persist($Remb);
            
            $em->flush();
            return $this->sendResponse(array('msg'=>'Creance  remboursée avec succès Restant: !'.$CreanceNew->getTotalRestant()));
            
            
        
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Creance:_form.html.twig', array('form'=>$fourForm->createView()));
        else
       return $this->render('GOShopBundle:Creance:index.html.twig', array('form'=>$fourForm->createView()));
            
        
            
    }
    /**
     * 
     * @param CreanceProduit $creance
     * @param Request $req
     * @return Response
     * * @Route("creance_liquide_remb-{id}-{montant}.golob", defaults={"montant"=0}, name="creance_liquide_rembourser")
    
     */
    public function crLiquideRembAction(CreanceLiquide $creance,Request $req)
    {
        $Remb=new RembCreanceLiquide();
         $Remb->setShop($this->getShop())->setUser($this->getUser());
         $Remb->setCreance($creance);
         $Remb->setMontant($req->get('montant'));
         // vérifie si le montant remboursé et supérieur ou égal à la somme totale de la créance, si oui on marque
         //la créance comme remboursée pour qu'elle n'apparaisse plus dans la liste des créances non payées
         $em=$this->em();
         if($Remb->getMontant()>$creance->getTotalRestant())
             return $this->sendResponse(array('errorMsg'=>"Le montant renseigné est supérieur au montant restant de la créance"));
         if($Remb->getMontant()>=$creance->getTotal())
         {
             $creance->setRembourse (true);$em->persist($creance);
         }
            
            $em->persist($creance);
            //======Versement à la caisse
            $Caisse=$this->getCaisse();
            $Caisse->ajouter($Remb->getMontant());
            $em->persist($Caisse);
            $em->persist($Remb);
            
            $em->flush();
            return $this->sendResponse(array('msg'=>'Creance  remboursée avec succès!'));
            
            
        
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Creance:_form.html.twig', array('form'=>$fourForm->createView()));
        else
       return $this->render('GOShopBundle:Creance:index.html.twig', array('form'=>$fourForm->createView()));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("creance_index.golob", name="creance_index")
     */
    public function newAction(Request $req)
    {
        $creance=new CreanceProduit();
        $fourForm=$this->createForm(new CreanceProduitType(), $creance);
        $msg=null;
        $errorMsg=null;
        
        if($req->getMethod()=="POST")
        {
            $fourForm->bind($req);
            $creance->setShop($this->getShop())->setUser($this->getUser());
            $stock= $this->getRepo('Stock')->findOneBy(array('produit'=>$creance->getProduit(), 'shop'=>$creance->getShop()));
        
            if($fourForm->isValid())
            {
               if(!$stock->isVide()&& $stock->isDispo($creance->getQuantite()))
             {
                $em=$this->em();
                $em->persist($creance);
                //======Stock
                $Stock=$this->getRepo('Stock')->findOneBy(array('shop'=> $this->getShop(),"produit"=>$creance->getProduit()));
                $Stock->diminuer($creance->getQuantite());
                $em->persist($Stock);

                $em->flush();
                $msg='Creance  enregistrée avec succès!';
            }else
            {
                $errorMsg="Stock insuffisant pour le produit ".$creance->getProduit()->getNom();
            }
            }
            //if form is not valide
            else
            {
                $errorMsg="Formulaire invalide. Les donnees envoyées ne sont pas correctes";
            }
            
        } 
        
       return $this->sendResponse(array('view'=>'GOShopBundle:Creance:index.html.twig', 
               'responseVars'=>array('form'=>$fourForm->createView()),
               'msg'=>$msg,
               'errorMsg'=>$errorMsg
               ));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("creance_liquide_index.golob", name="creance_liquide_index")
     */
    public function creanceLiquideNewAction(Request $req)
    {
        $creance=new CreanceLiquide();
        $fourForm=$this->createForm(new CreanceLiquideType(), $creance);
        
        if($req->getMethod()=="POST")
        {
            $fourForm->bind($req);
            $creance->setShop($this->getShop())->setUser($this->getUser());
            if($fourForm->isValid())
            {
            $em=$this->em();
            $em->persist($creance);
            //======Caisse
            $Caisse=$this->getRepo('Caisse')->findOneByShop($this->getShop());
            $Caisse->diminuer($creance->getMontant());
            $em->persist($Caisse);
            
            $em->flush();
            return new Response('Creance  liquide enregistrée avec succès!');
            }
            
        } 
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Creance:_cr_liquide_form.html.twig', array('form'=>$fourForm->createView()));
       else
           return $this->render('GOShopBundle:Creance:cr_liquide_index.html.twig', array('form'=>$fourForm->createView()));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return Response
     * @Route("creance_update-{id}.golob", name="go_shop_creance_update")
    
     */
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
        /**
         * 
         * @param CreanceProduit $creance
         * @param Request $req
         * @return type
         * @throws NotFoundHttpException
         * @Route("creance_delete-{id}.golob", name="go_shop_creance_supprimer")
    
        */
         
      public function deleteAction(CreanceProduit $creance,Request $req)
        {
            $vente= $this->getRepo('Vente')->find($req->get('id'));
            $msg=null;
            $errorMsg=null;
            if(!is_null($vente))
            {
                $em=$this->em();
                $em->remove($vente);
                $Stock=$this->getRepo('Stock')->findOneBy(array('shop'=> $this->getShop(), 'produit'=>$vente->getProduit()));
                $Stock->setQuantite($vente->getQuantite()+$Stock->getQuantite());
                $em->persist($Stock);
                try {
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
            }else
            {
                throw new NotFoundHttpException('Vente Introuvable!');
            }
        }
        /**
         * 
         * @param CreanceProduit $creance
         * @param Request $req
         * @return type
         * @throws NotFoundHttpException
         * @Route("creance_liquide_delete-{id}.golob", name="creance_liquide_annuler")
    
        */
         
      public function deleteLiquideAction(CreanceLiquide $creance,Request $req)
        {
          $msg=null;
            $errorMsg=null;
            
                $em=$this->em();
                $em->remove($creance);
                try {
                   $em->flush();
                   $msg="Créance supprimée avec succès!";
                   
                } catch (Exception $ex) {
                    $msg=$ex->getMessage();
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
     * @param Request $req
     * @return type
     * @Route("creance_show.golob", name="go_shop_creance_show")
     */
    public function showAction(Request $req)
    {
        $creances= $this->getRepo('CreanceProduit')->getCreancesNonRemb($this->getShop());
            return $this->render('GOShopBundle:Creance:liste.html.twig', array('creances'=>$creances));
            
        
            
    }
        /**
     * 
     * @param Request $req
     * @return type
     * @Route("creance_liquide_show.golob", name="go_shop_creance_liquide_show")
     */
    public function crLiquideShowAction(Request $req)
    {
        $creances= $this->getRepo('CreanceLiquide')->getCreancesNonRemb($this->getShop());
            return $this->render('GOShopBundle:Creance:cr_liquide_liste.html.twig', array('creances'=>$creances));
            
        
            
    }
}