<?php
namespace GO\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ShopBundle\Form\DetteFactureType;
use GO\ShopBundle\Form\DetteLiquideType;
use GO\ShopBundle\Entity\DetteLiquide;
use GO\ShopBundle\Entity\DetteFacture;
use GO\ShopBundle\Entity\Fournisseur;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
/**
 * Description of DetteController
 *
 * @author hp
 */
class DetteController extends MainController {
    
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Enregistrer nouvelle", "id"=>"", "href"=>"dette_index.golob"),
           array("libelle"=>"Enregistrer Liquide", "id"=>"", "href"=>"dette_liquide_index.golob"),
            array("libelle"=>"Recherche", "id"=>"", "href"=>"produit_search_index.golob"),
           array("libelle"=>"Créance Liquide", "id"=>"", "href"=>"#", 
                 "dropdown"=>array(
                                array("libelle"=>"Ajouter une Catégorie", "id"=>"", "href"=>"produit_cat_index.golob"),
                                array("libelle"=>"Liste des Catégories", "id"=>"", "href"=>"produit_cat_show.golob"),
                          )
               
               ),
           array("libelle"=>"Liste", "id"=>"", "href"=>"dette_show.golob"),
           array("libelle"=>"Liste créance liquide", "id"=>"", "href"=>"dette_liquide_show.golob"),
           array("libelle"=>"Plus", "id"=>"", "href"=>"stock_index.golob"),
           );
        return $this->render('GOShopBundle:Vente:menu_vertical.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("dette_index.golob", name="dette_index")
     */
    public function newAction(Request $req)
    {
        $dette=new DetteLiquide();
        $fourForm=$this->createForm(new DetteLiquideType(), $dette);
        
        if($req->getMethod()=="POST")
        {
            $fourForm->bind($req);
            $dette->setShop($this->getShop())->setUser($this->getUser());
            if($fourForm->isValid())
            {
            $em=$this->em();
            $em->persist($dette);
            //======Stock
            $Caisse=$this->getRepo('Caisse')->findOneByShop($this->getShop());
            $Caisse->ajouter($dette->getMontant());
            $em->persist($Caisse);
            
            $em->flush();
            return new Response('Dette  enregistrée avec succès!');
            }
            
        } 
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:Dette:_form.html.twig', array('form'=>$fourForm->createView()));
        else
       return $this->render('GOShopBundle:Dette:index.html.twig', array('form'=>$fourForm->createView()));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("dette_liquide_index.golob", name="dette_liquide_index")
     */
    public function detteLiquideNewAction(Request $req)
    {
        $dette=new detteLiquide();
        $fourForm=$this->createForm(new detteLiquideType(), $dette);
        
        if($req->getMethod()=="POST")
        {
            $fourForm->bind($req);
            $dette->setShop($this->getShop())->setUser($this->getUser());
            if($fourForm->isValid())
            {
            $em=$this->em();
            $em->persist($dette);
            //======Caisse
            $Caisse=$this->getRepo('Caisse')->findOneByShop($this->getShop());
            $Caisse->diminuer($dette->getMontant());
            $em->persist($Caisse);
            
            $em->flush();
            return new Response('dette  liquide enregistrée avec succès!');
            }
            
        } 
        if($req->isXmlHttpRequest())
       return $this->render('GOShopBundle:dette:_cr_liquide_form.html.twig', array('form'=>$fourForm->createView()));
       else
           return $this->render('GOShopBundle:dette:cr_liquide_index.html.twig', array('form'=>$fourForm->createView()));
            
        
            
    }
    /**
     * 
     * @param Request $req
     * @return Response
     * @Route("dette_update-{id}.golob", name="go_shop_dette_update")
    
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
         * @param detteProduit $dette
         * @param Request $req
         * @return type
         * @throws NotFoundHttpException
         * @Route("dette_delete-{id}.golob", name="go_shop_dette_supprimer")
    
        */
         
      public function deleteAction(detteProduit $dette,Request $req)
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
     * @param Request $req
     * @return type
     * @Route("dette_show.golob", name="go_shop_dette_show")
     */
    public function showAction(Request $req)
    {
        $dettes= $this->getRepo('detteProduit')->findAll();
            return $this->render('GOShopBundle:dette:liste.html.twig', array('dettes'=>$dettes));
            
        
            
    }
        /**
     * 
     * @param Request $req
     * @return type
     * @Route("dette_liquide_show.golob", name="go_shop_dette_liquide_show")
     */
    public function crLiquideShowAction(Request $req)
    {
        $dettes= $this->getRepo('detteLiquide')->findAll();
            return $this->render('GOShopBundle:dette:cr_liquide_liste.html.twig', array('dettes'=>$dettes));
            
        
            
    }
}