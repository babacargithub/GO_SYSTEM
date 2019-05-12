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
class ShopSummary {
    //put your code here
    
        private $capitalExercice;
        private $totalDetteLiquide;//function to create
        private $totalDetteFacture;//function to create
        private $totalCreanceLiquide;//function to create
        private $totalCreanceProduit;//function to create
        private $valeurStock;
        private $totalVenteExercice;//function to create
        private $totalVenteMois;
        private $totalVenteMoisPasseExercice;//=array();//function to create
        private $totalVenteJour;
        private $totalAchatExercice;//function to create
        private $totalAchatMois;
        private $totalAchatMoisPasseExercice;//function to create
        private $totalAchatJour;
        private $totalCreanceLiquideExercice;//function to create
        private $totalCreanceLiquideMois;
        private $totalCreanceLiquideMoisPasseExercice;//function to create
        private $totalCreanceLiquideJour;
        private $totalCreanceProduitExercice;//function to create
        private $totalCreanceProduitMois;
        private $totalCreanceProduitMoisPasseExercice;//function to create
        private $totalCreanceProduitJour;
        private $totalBeneficeExercice;//function to create
        private $totalBeneficeMoisPasseExercice;//function to create
        private $totalBeneficeMois;
        private $totalBeneficeJour;
        private $soldeCaisse;
        private $soldeBanque;//function to create
        private $pourcentageOJV;//function to create
        private $venteJourExercicePrecedent;//function to create
        private $venteMoisExercicePrecedent;//function to create
        private $nombreArticleVenduJour;
        private $nombreArticleVenduMois;
        private $nombreCompteOuvertMois;//function to create
        private $nombreCompteOuvertJour;//function to create
        private $totalVenteTypeProduit;//function to create
        private $totalBeneficeTypeProduit;//function to create
        private $nombreArticleVenduTypeProduit;//function to create
        private $totalDepenseExercice;
        private $shop;
        private $tauxProgressCapital;
        private $valeurBoutique;
        private $monthlyReports=array();
        private $beneficeNet;
        public function getTotalDepenseExercice() {
            return $this->totalDepenseExerice;
        }

        public function setTotalDepenseExercice($totalDepenseExerice) {
            $this->totalDepenseExerice = $totalDepenseExerice;
        }

       public function getTauxProgressCapital() {
            
            $valeurBoutique=$this->getValeurBoutique();
           return $result=(($valeurBoutique-$this->capitalExercice)/$this->capitalExercice)*100;
            
                
                
        }


         public function getShop() {
            return $this->shop;
        }

        public function setShop(\GO\ShopBundle\Entity\Shop $shop) {
            $this->shop = $shop;
        }

                public function getCapitalExercice() {
            return $this->capitalExercice;
        }

        public function getTotalDetteLiquide() {
            return $this->totalDetteLiquide;
        }

        public function getTotalDetteFacture() {
            return $this->totalDetteFacture;
        }

        public function getTotalCreanceLiquide() {
            return $this->totalCreanceLiquide;
        }

        public function getTotalCreanceProduit() {
            return $this->totalCreanceProduit;
        }

        public function getValeurStock() {
            return $this->valeurStock;
        }

        public function getTotalVenteExercice() {
            return $this->totalVenteExercice;
        }

        public function getTotalVenteMois() {
            return $this->totalVenteMois;
        }

        public function getTotalVenteMoisPasseExercice() {
            return $this->totalVenteMoisPasseExercice;
        }

        public function getTotalVenteJour() {
            return $this->totalVenteJour;
        }

        public function getTotalAchatExercice() {
            return $this->totalAchatExercice;
        }

        public function getTotalAchatMois() {
            return $this->totalAchatMois;
        }

        public function getTotalAchatMoisPasseExercice() {
            return $this->totalAchatMoisPasseExercice;
        }

        public function getTotalAchatJour() {
            return $this->totalAchatJour;
        }

        public function getTotalCreanceLiquideExercice() {
            return $this->totalCreanceLiquideExercice;
        }

        public function getTotalCreanceLiquideMois() {
            return $this->totalCreanceLiquideMois;
        }

        public function getTotalCreanceLiquideMoisPasseExercice() {
            return $this->totalCreanceLiquideMoisPasseExercice;
        }

        public function getTotalCreanceLiquideJour() {
            return $this->totalCreanceLiquideJour;
        }

        public function getTotalCreanceProduitExercice() {
            return $this->totalCreanceProduitExercice;
        }

        public function getTotalCreanceProduitMois() {
            return $this->totalCreanceProduitMois;
        }

        public function getTotalCreanceProduitMoisPasseExercice() {
            return $this->totalCreanceProduitMoisPasseExercice;
        }

        public function getTotalCreanceProduitJour() {
            return $this->totalCreanceProduitJour;
        }

        public function getTotalBeneficeExercice() {
            return $this->totalBeneficeExercice;
        }

        public function getTotalBeneficeMoisPasseExercice() {
            return $this->totalBeneficeMoisPasseExercice;
        }

        public function getTotalBeneficeMois() {
            return $this->totalBeneficeMois;
        }

        public function getTotalBeneficeJour() {
            return $this->totalBeneficeJour;
        }

        public function getSoldeCaisse() {
            return $this->soldeCaisse;
        }

        public function getSoldeBanque() {
            return $this->soldeBanque;
        }

        public function getPourcentageOJV() {
            return $this->pourcentageOJV;
        }

        public function getVenteJourExercicePrecedent() {
            return $this->venteJourExercicePrecedent;
        }

        public function getVenteMoisExercicePrecedent() {
            return $this->venteMoisExercicePrecedent;
        }

        public function getNombreArticleVenduJour() {
            return $this->nombreArticleVenduJour;
        }

        public function getNombreArticleVenduMois() {
            return $this->nombreArticleVenduMois;
        }

        public function getNombreCompteOuvertMois() {
            return $this->nombreCompteOuvertMois;
        }

        public function getNombreCompteOuvertJour() {
            return $this->nombreCompteOuvertJour;
        }

        public function getTotalVenteTypeProduit() {
            return $this->totalVenteTypeProduit;
        }

        public function getTotalBeneficeTypeProduit() {
            return $this->totalBeneficeTypeProduit;
        }

        public function getNombreArticleVenduTypeProduit() {
            return $this->nombreArticleVenduTypeProduit;
        }

        public function setCapitalExercice($capitalExercice) {
            $this->capitalExercice = $capitalExercice;
        }

        public function setTotalDetteLiquide($totalDetteLiquide) {
            $this->totalDetteLiquide = $totalDetteLiquide;
        }

        public function setTotalDetteFacture($totalDetteFacture) {
            $this->totalDetteFacture = $totalDetteFacture;
        }

        public function setTotalCreanceLiquide($totalCreanceLiquide) {
            $this->totalCreanceLiquide = $totalCreanceLiquide;
        }

        public function setTotalCreanceProduit($totalCreanceProduit) {
            $this->totalCreanceProduit = $totalCreanceProduit;
        }

        public function setValeurStock($valeurStock) {
            $this->valeurStock = $valeurStock;
        }

        public function setTotalVenteExercice($totalVenteExercice) {
            $this->totalVenteExercice = $totalVenteExercice;
        }

        public function setTotalVenteMois($totalVenteMois) {
            $this->totalVenteMois = $totalVenteMois;
        }

        public function setTotalVenteMoisPasseExercice($totalVenteMoisPasseExercice) {
            $this->totalVenteMoisPasseExercice = $totalVenteMoisPasseExercice;
        }

        public function setTotalVenteJour($totalVenteJour) {
            $this->totalVenteJour = $totalVenteJour;
        }

        public function setTotalAchatExercice($totalAchatExercice) {
            $this->totalAchatExercice = $totalAchatExercice;
        }

        public function setTotalAchatMois($totalAchatMois) {
            $this->totalAchatMois = $totalAchatMois;
        }

        public function setTotalAchatMoisPasseExercice($totalAchatMoisPasseExercice) {
            $this->totalAchatMoisPasseExercice = $totalAchatMoisPasseExercice;
        }

        public function setTotalAchatJour($totalAchatJour) {
            $this->totalAchatJour = $totalAchatJour;
        }

        public function setTotalCreanceLiquideExercice($totalCreanceLiquideExercice) {
            $this->totalCreanceLiquideExercice = $totalCreanceLiquideExercice;
        }

        public function setTotalCreanceLiquideMois($totalCreanceLiquideMois) {
            $this->totalCreanceLiquideMois = $totalCreanceLiquideMois;
        }

        public function setTotalCreanceLiquideMoisPasseExercice($totalCreanceLiquideMoisPasseExercice) {
            $this->totalCreanceLiquideMoisPasseExercice = $totalCreanceLiquideMoisPasseExercice;
        }

        public function setTotalCreanceLiquideJour($totalCreanceLiquideJour) {
            $this->totalCreanceLiquideJour = $totalCreanceLiquideJour;
        }

        public function setTotalCreanceProduitExercice($totalCreanceProduitExercice) {
            $this->totalCreanceProduitExercice = $totalCreanceProduitExercice;
        }

        public function setTotalCreanceProduitMois($totalCreanceProduitMois) {
            $this->totalCreanceProduitMois = $totalCreanceProduitMois;
        }

        public function setTotalCreanceProduitMoisPasseExercice($totalCreanceProduitMoisPasseExercice) {
            $this->totalCreanceProduitMoisPasseExercice = $totalCreanceProduitMoisPasseExercice;
        }

        public function setTotalCreanceProduitJour($totalCreanceProduitJour) {
            $this->totalCreanceProduitJour = $totalCreanceProduitJour;
        }

        public function setTotalBeneficeExercice($totalBeneficeExercice) {
            $this->totalBeneficeExercice = $totalBeneficeExercice;
        }

        public function setTotalBeneficeMoisPasseExercice($totalBeneficeMoisPasseExercice) {
            $this->totalBeneficeMoisPasseExercice = $totalBeneficeMoisPasseExercice;
        }

        public function setTotalBeneficeMois($totalBeneficeMois) {
            $this->totalBeneficeMois = $totalBeneficeMois;
        }

        public function setTotalBeneficeJour($totalBeneficeJour) {
            $this->totalBeneficeJour = $totalBeneficeJour;
        }

        public function setSoldeCaisse($soldeCaisse) {
            $this->soldeCaisse = $soldeCaisse;
        }

        public function setSoldeBanque($soldeBanque) {
            $this->soldeBanque = $soldeBanque;
        }

        public function setPourcentageOJV($pourcentageOJV) {
            $this->pourcentageOJV = $pourcentageOJV;
        }

        public function setVenteJourExercicePrecedent($venteJourExercicePrecedent) {
            $this->venteJourExercicePrecedent = $venteJourExercicePrecedent;
        }

        public function setVenteMoisExercicePrecedent($venteMoisExercicePrecedent) {
            $this->venteMoisExercicePrecedent = $venteMoisExercicePrecedent;
        }

        public function setNombreArticleVenduJour($nombreArticleVenduJour) {
            $this->nombreArticleVenduJour = $nombreArticleVenduJour;
        }

        public function setNombreArticleVenduMois($nombreArticleVenduMois) {
            $this->nombreArticleVenduMois = $nombreArticleVenduMois;
        }

        public function setNombreCompteOuvertMois($nombreCompteOuvertMois) {
            $this->nombreCompteOuvertMois = $nombreCompteOuvertMois;
        }

        public function setNombreCompteOuvertJour($nombreCompteOuvertJour) {
            $this->nombreCompteOuvertJour = $nombreCompteOuvertJour;
        }

        public function setTotalVenteTypeProduit($totalVenteTypeProduit) {
            $this->totalVenteTypeProduit = $totalVenteTypeProduit;
        }

        public function setTotalBeneficeTypeProduit($totalBeneficeTypeProduit) {
            $this->totalBeneficeTypeProduit = $totalBeneficeTypeProduit;
        }

        public function setNombreArticleVenduTypeProduit($nombreArticleVenduTypeProduit) {
            $this->nombreArticleVenduTypeProduit = $nombreArticleVenduTypeProduit;
        }

        public function getValeurBoutique() {
            
            $valeur= $this->valeurStock+$this->soldeCaisse+$this->soldeBanque+$this->totalCreanceLiquide+
                    $this->totalCreanceProduit-$this->totalDetteLiquide-$this->totalDetteFacture;
            return (int) $valeur;
        }
        public function getMonthlyReports() {
            return $this->monthlyReports;
        }

        public function setMonthlyReports($monthlyReports) {
            $this->monthlyReports = $monthlyReports;
        }

        public function getBeneficeNet()
        {
           return ( $benef= $this->getTotalBeneficeExercice()-$this->getTotalDepenseExercice());
        }
        

       
}
