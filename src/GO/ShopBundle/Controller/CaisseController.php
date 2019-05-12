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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;;
use GO\ShopBundle\Entity\Shop;
use GO\ShopBundle\Entity\Caisse;
use GO\ShopBundle\Entity\Sortie;
use GO\ShopBundle\Utils\Constants as Cons;
use GO\ShopBundle\Utils\CustomValidator as Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Description of VenteController
 *
 * @author hp
 */
class CaisseController extends MainController {
    //put your code here
    /**
     * 
     * @param Request $req
     * @return type
     * @Route("show_caisse.golob", name="caisse_show")
     */
     public function showCaisseAction(Request $req)
    {
        $caisse=$this->getRepo('Caisse')->findOneByShop($this->getShop());
        return $this->render('GOShopBundle:Caisse:caisse.html.twig', array('caisse'=>$caisse));
    }
}
    