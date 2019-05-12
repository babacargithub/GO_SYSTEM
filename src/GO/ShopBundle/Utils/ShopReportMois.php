<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Utils;

/**
 * Description of ShopSummary
 *
 * @author LBC
 */
class ShopReportMois {
    //put your code here
    
        private $capitalMois;
        private $detteLiquideMois;//function to create
        private $detteFactureMois;//function to create
        private $valeurStock;
        private $venteMois;
        private $achatMoisPaye;
        private $achatMoisNonPaye;
        private $creanceLiquideMois;
        private $creanceProduitMois;
        private $beneficeMois;
        private $depenseMois;
        private $OJVMois;
        private $pourcentageOJV;//function to create
        private $nombreArticleVenduMois;
        private $nombreCompteOuvertMois;//function to create
        private $venteTypeProduit;//function to create
        private $beneficeTypeProduit;//function to create
        private $nombreArticleVenduTypeProduit;//function to create
        private $shop;
        private $tauxProgressCapital;
        private $valeurBoutique;
        private $moisLibelle;
        
        public function getDepenseMois() {
            return $this->depenseMois;
        }

        public function setDepenseMois($depenseMois) {
            $this->depenseMois = $depenseMois;
        }

                public function getCapitalMois() {
            return $this->capitalMois;
        }

        public function getDetteLiquideMois() {
            return $this->detteLiquideMois;
        }

        public function getDetteFactureMois() {
            return $this->detteFactureMois;
        }

        public function getValeurStock() {
            return $this->valeurStock;
        }

        public function getVenteMois() {
            return $this->venteMois;
        }

        public function getAchatMoisPaye() {
            return $this->achatMoisPaye;
        }

        public function getAchatMoisNonPaye() {
            return $this->achatMoisNonPaye;
        }

        public function getCreanceLiquideMois() {
            return $this->creanceLiquideMois;
        }

        public function getCreanceProduitMois() {
            return $this->creanceProduitMois;
        }

        public function getBeneficeMois() {
            return $this->beneficeMois;
        }

        public function getOJVMois() {
            return $this->OJVMois;
        }

        public function getPourcentageOJV() {
            return $this->pourcentageOJV;
        }

        public function getNombreArticleVenduMois() {
            return $this->nombreArticleVenduMois;
        }

        public function getNombreCompteOuvertMois() {
            return $this->nombreCompteOuvertMois;
        }

        public function getVenteTypeProduit() {
            return $this->venteTypeProduit;
        }

        public function getBeneficeTypeProduit() {
            return $this->beneficeTypeProduit;
        }

        public function getNombreArticleVenduTypeProduit() {
            return $this->nombreArticleVenduTypeProduit;
        }

        public function getShop() {
            return $this->shop;
        }

        public function getTauxProgressCapital() {
            return $this->tauxProgressCapital;
        }

        public function getValeurBoutique() {
            return $this->valeurBoutique;
        }

        public function setCapitalMois($capitalMois) {
            $this->capitalMois = $capitalMois;
        }

        public function setDetteLiquideMois($detteLiquideMois) {
            $this->detteLiquideMois = $detteLiquideMois;
        }

        public function setDetteFactureMois($detteFactureMois) {
            $this->detteFactureMois = $detteFactureMois;
        }

        public function setValeurStock($valeurStock) {
            $this->valeurStock = $valeurStock;
        }

        public function setVenteMois($venteMois) {
            $this->venteMois = $venteMois;
        }

        public function setAchatMoisPaye($achatMoisPaye) {
            $this->achatMoisPaye = $achatMoisPaye;
        }

        public function setAchatMoisNonPaye($achatMoisNonPaye) {
            $this->achatMoisNonPaye = $achatMoisNonPaye;
        }

        public function setCreanceLiquideMois($creanceLiquideMois) {
            $this->creanceLiquideMois = $creanceLiquideMois;
        }

        public function setCreanceProduitMois($creanceProduitMois) {
            $this->creanceProduitMois = $creanceProduitMois;
        }

        public function setBeneficeMois($beneficeMois) {
            $this->beneficeMois = $beneficeMois;
        }

        public function setOJVMois($OJVMois) {
            $this->OJVMois = $OJVMois;
        }

        public function setPourcentageOJV($pourcentageOJV) {
            $this->pourcentageOJV = $pourcentageOJV;
        }

        public function setNombreArticleVenduMois($nombreArticleVenduMois) {
            $this->nombreArticleVenduMois = $nombreArticleVenduMois;
        }

        public function setNombreCompteOuvertMois($nombreCompteOuvertMois) {
            $this->nombreCompteOuvertMois = $nombreCompteOuvertMois;
        }

        public function setVenteTypeProduit($venteTypeProduit) {
            $this->venteTypeProduit = $venteTypeProduit;
        }

        public function setBeneficeTypeProduit($beneficeTypeProduit) {
            $this->beneficeTypeProduit = $beneficeTypeProduit;
        }

        public function setNombreArticleVenduTypeProduit($nombreArticleVenduTypeProduit) {
            $this->nombreArticleVenduTypeProduit = $nombreArticleVenduTypeProduit;
        }

        public function setShop($shop) {
            $this->shop = $shop;
        }

        public function setTauxProgressCapital($tauxProgressCapital) {
            $this->tauxProgressCapital = $tauxProgressCapital;
        }

        public function setValeurBoutique($valeurBoutique) {
            $this->valeurBoutique = $valeurBoutique;
        }
        public function getMoisLibelle() {
            return $this->moisLibelle;
        }

        public function setMoisLibelle($moisLibelle) {
            $this->moisLibelle = $moisLibelle;
        }




       
}
