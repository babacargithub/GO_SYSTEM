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
use GO\ShopBundle\Form as GOShopForm;
use GO\ShopBundle\Entity as GOShopEntity;

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
class TestController extends MainController {
    //put your code here
    /**
     * 
     * @param Request $req
     * @Route("/test/test_get_entrees", name="test_get_entrees_")
     */
    public function testGetEntreesAchat(Request $req)
    {
       //testé avec "" comme arguement, Résultat: exception lancée
       //  $achatRepo= $this->getRepo('Achat')->getEntrees($this->getShop(),"");
        //testé avec NULL comme arguement, Résultat: exception lancée
       //  $achatRepo= $this->getRepo('Achat')->getEntrees($this->getShop(),null);
        $achatRepo= $this->getRepo('Achat')->getEntrees($this->getShop(),999999999);
        //$achatRepo= $this->getRepo('Achat')->getEntrees($this->getShop(),"");
        $number=0;
         foreach($achatRepo as $item)
        $number++;
        echo $number;
        exit();
    }
    /**
     * 
     * @param Request $req
     * @Route("/test/test_get_sorties", name="test_get_sorties_")
     */
    public function testGetSortiesAchat(Request $req)
    {
        $achatRepo= $this->getRepo('Achat')->getSorties($this->getShop(),
                $achat= $this->getRepo("Achat")->find(5585),
                GOShopEntity\AchatRepository::ACHAT_SORTIE_STOCK_);
        $number=0;
        print_r($achatRepo);die();
         foreach($achatRepo as $item)
        $number++;
        echo $number;
        exit();
    }
    /**
     * 
     * @param Request $req
     * @Route("/test/test_output", name="test_output_to_number_")
     */
    public function testOutputAction(Request $req)
    {
       
        $string="Cocopulp Lait GM";
        $produits=$this->getRepo('Produit')->findAll();
        $produit= $this->getRepo('Produit')->findOneByNom("Protège Slip");
        
       // var_dump($produit->getDefaultCodeBar()); exit();
        $batchSize=60; $i=1;
        $em= $this->em();
        foreach ($produits as $produit) 
        {
            $produit->generateDefaultCodeBar();
            //var_dump($produit->getDefaultCodeBar());
            $em->persist($produit); 
            if(($i%$batchSize)===0)
            {//exit();
                
            }
           ++$i; 
        }$em->flush(); 
        exit("Toutes les modifs sont enregistrés");
        $encrypted_=\GO\ShopBundle\Utils\LetterToNumber::letterToNumber($string);
        echo $encrypted_.'--------';
       echo \GO\ShopBundle\Utils\LetterToNumber::numberToLetter($encrypted_);
        exit();
        
    }
    /**
     * 
     * @param \GO\ShopBundle\Entity\Inventaire $inventaire
     * @Route("test/create_defaults_from_inventaire/{id}", name="create_default_codebars")
     */
    public function createDefaultStockCodeBars(GOShopEntity\Inventaire $inventaire)
    {
        $em= $this->em();
        $ventes= $this->getRepo('Vente')->createQueryBuilder('v')
                ->select('v')->where('DATE(v.date)>:date')
                ->andWhere('v.codeBar IS NOT  NULL')
                ->andWhere('v.shop=:shop')
               ->andWhere('v.codeBar <5603')
                ->setParameter('date',new \DateTime("2019-04-06"))
                ->setParameter('shop', $this->getShop())
                ->getQuery()->getResult();
//$cdb=$this->getRepo('Achat')->findOneByCodeBar($this->getRepo('Produit')->findOneByNom("Rallonge Amely")->getDefaultCodeBar());
   $i=0;
   foreach ($ventes as $vente)
{
    $i++;
    /*$cdb=$this->getRepo('Achat')->findOneByCodeBar($vente->getProduit()->getDefaultCodeBar());
    if(null!==$cdb)
    {
    $vente->setCodeBar($cdb);
    }*/
       $achat=$vente->getCodeBar();
       $achat->setQuantiteRestant($achat->getQuantiteRestant()-$vente->getQuantite());
  //echo "<$i>--".$vente->getProduit().'<-'.$vente->getDate()->format('d-m-Y H:i:s').'-><br>';
    $em->persist($achat);
}
$ventes= $this->getRepo('Vente')->createQueryBuilder('v')
                ->select('v')->where('DATE(v.date)>:date')
                ->andWhere('v.codeBar IS  NULL')
                ->andWhere('v.shop=:shop')
               // ->andWhere('v.codeBar <5602')
                ->setParameter('date',new \DateTime("2019-04-06"))
                ->setParameter('shop', $this->getShop())
                ->getQuery()->getResult();
   foreach ($ventes as $vente)
{
    $i++;
    $achat=$this->getRepo('Achat')->findOneByCodeBar($vente->getProduit()->getDefaultCodeBar());
    if(null!==$achat)
    {
   
    
       //$achat=$vente->getCodeBar();
       $achat->setQuantiteRestant($achat->getQuantiteRestant()-$vente->getQuantite());
  //echo "<$i>--".$vente->getProduit().'<-'.$vente->getDate()->format('d-m-Y H:i:s').'-><br>';
    $em->persist($achat);
    $vente->setCodeBar($achat);
    $em->persist($vente);
    }
}
$em->flush();

exit( "Toutes les insertions ont réussi");
       /* $factureAchat=(new GOShopEntity\FactureAchat)
                ->setFournisseur($this->getRepo('Fournisseur')->find(89))
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
                    $produitInv->setCodeBar($achat);
                    $em->persist($produitInv);
                   }
                    
                }
        
        */
                $em->flush();
                return new Response("Defauts successfully created");
    }
    /**
     * @Route("test/create_code_bars", name="_create_for_not_having")
     */
    public function createCodeBarsForFacturesNotHaving()
    {
        $em= $this->em();
        $achats= $this->getRepo('Achat')->createQueryBuilder('a')
                ->select('a')->where('DATE(a.date)>:date')
                ->join('a.facture',"fa")->where('DATE(fa.date)>:date')
                ->andWhere('fa.shop=:shop')
               // ->andWhere('a.codeBar IS NULL')
                ->setParameter('date',new \DateTime("2019-04-06"))
                ->setParameter('shop', $this->getShop())
                ->getQuery()->getResult();
        $i=0;
        foreach ($achats as $achat)
        {
            
            $achat->setQuantiteRestant($achat->getQuantite());
            $em->persist($achat);
            
            
            
                $i++;
        }
        $em->flush();
        Exit("Créations réussi!  $i Rows affected!");
    }
    
/**
 * @Route("/test/test_client_caravane", name="testclientcaravane")
 */
    public function testClientCaravaneAction()
    {
        $client= new \GO\CaravaneBundle\Entity\Client();
        $client->setCoordonnees($this->getDoctrine()->getRepository("GOClientBundle:Client")->find(1));
        echo $client->getAdresse();
        die();
    }
}
