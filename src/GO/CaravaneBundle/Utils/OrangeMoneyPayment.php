<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaravaneBundle\Utils;
use GO\MainBundle\Utils\OrangeMoneyOnlinePayment as OMP;
use GO\CaravaneBundle\Entity\Reservation;
use \Paydunya;
use \Paydunya\Checkout\CheckoutInvoice;
use \Paydunya\Setup;
use \Paydunya\Checkout\Store;
/**
 * Description of OrangeMoneyPayment
 *
 * @author Golob One
 */
class OrangeMoneyPayment extends OMP{
    //put your code here
    protected $notificationUrl;
    protected $successMssage;
    protected $failMessage;
    protected $returnUrl;
    protected $cancelUrl;
            function getNotificationUrl() {
        return $this->notificationUrl;
    }

    function getSuccessMssage() {
        return $this->successMssage;
    }

    function getFailMessage() {
        return $this->failMessage;
    }

    function getReturnUrl() {
        return $this->returnUrl;
    }

    function getCancelUrl() {
        return $this->cancelUrl;
    }

    function setNotificationUrl($notificationUrl) {
        $this->notificationUrl = $notificationUrl;
    }

    function setSuccessMssage($successMssage) {
        $this->successMssage = $successMssage;
    }

    function setFailMessage($failMessage) {
        $this->failMessage = $failMessage;
    }

    function setReturnUrl($returnUrl) {
        $this->returnUrl = $returnUrl;
    }

    function setCancelUrl($cancelUrl) {
        $this->cancelUrl = $cancelUrl;
    }

        public function facturer($res) {
        $facture = new CheckoutInvoice;
        $facture->addCustomData('name', $res->getClient()->getNomComplet());
        $facture->addCustomData('phone', $res->getClient()->getTel());
        $facture->addCustomData('email', "golobone@gmail.com");
        $facture->addCustomData('id_res', $res->getId());
        $montant=$res->getDes()->getTarif()+150;
        $montant= intval($montant);
        $facture->setTotalAmount($montant);
        $facture->setCancelUrl($this->cancelUrl);
        $facture->setReturnUrl($this->returnUrl);
       
        $facture->addItem('Ticket Voyage Caravane Golob One', 1, $montant, $montant);
        $facture->create();
        //var_dump($facture);exit();
        return $facture->getInvoiceUrl();
        
    }
}
