<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\MainBundle\Utils;
use \Paydunya;
use \Paydunya\Checkout\CheckoutInvoice;
use \Paydunya\Setup;
use \Paydunya\Checkout\Store;
/**
 * Description of OrangeMoneyOnlinePayment
 *
 * @author Golob One
 */
class OrangeMoneyOnlinePayment {
    //put your code here
public function __construct(){
Setup::setMasterKey("JXi0ERpN-hMFF-3toN-yDvj-L2N1OD3Rv1HB");
/*Setup::setPublicKey("test_public_Br2OMFdfXLchVR7aYFSrOcudF1Y");
Setup::setPrivateKey("test_private_rzi4q6CBS4N11wvDxuuIQlSKgEG");
Setup::setToken("mFn2XMITpIRFz0sEiKd7");
Setup::setMode("test"); */
// Optionnel. Utilisez cette option pour les paiements tests.
Setup::setPublicKey("live_public_wxTShDrIZT5tjpk7jh6VPgLjmKN");
Setup::setPrivateKey("live_private_IagZm7jehkClU1Gq04Y4nSrMM3p");
Setup::setToken("Kt48ZVN4UQlN9OZF3wWL");
Setup::setMode("live"); // Optionnel. Utilisez cette option pour les paiements tests.
 
 

//Configuration des informations de votre service/entreprise
Store::setName("CARAVANE GOLOB ONE"); // Seul le nom est requis
Store::setTagline("Toujours à votre service");
Store::setPhoneNumber("77 127 35 35");
Store::setPostalAddress("UGB, Université Gaston Berger");
Store::setWebsiteUrl("http://www.www.golobone.sn");
Store::setLogoUrl("http://www.chez-sandra.sn/logo.png");
Store::setReturnUrl("http://www.golobone.net/payer_online_success.golob");
Store::setCallbackUrl("http://www.golobone.net/online_pay_callback.golob");
    }
    public function facturer($object)
    {
        $facture = new CheckoutInvoice;
        $facture->addCustomData('name', "Babacar SEYE");
        $facture->addCustomData('phone', 773300853);
        $facture->addCustomData('email', "golobone@gmail.com");
       $facture->setTotalAmount($montant);
        $facture->setCancelUrl("/");
        $facture->setReturnUrl('/');
        //$facture->addChannel('orange-money-senegal');
        $facture->addItem('Paiement de la facture', 1, 3000, 3000);
        $facture->create();
        return $facture->getInvoiceUrl();
        //return $facture;
       
        
    }
    public function test()
    {
       $facture = new CheckoutInvoice;
       return $facture;
    }
}
