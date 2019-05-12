<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creance
 *
 * @ORM\Table(name="creance_produit")
 *  @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CreanceProduitRepository")
 */
class CreanceProduit extends CreanceBaseClass
{
   

    /**
     * @var \GO\ShopBundle\Entity\Produit
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="id",onDelete="NO ACTION",nullable=false)
     * })
     */
    private $produit;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixUnit", type="integer", nullable=false)
     */
    private $prixUnit;
    /**
     * @ORM\OneToMany(targetEntity="GO\ShopBundle\Entity\RembCreanceProduit", mappedBy="creance")
     */
    private $remboursements;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
   

    

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Creance
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixUnit
     *
     * @param integer $prixUnit
     * @return Creance
     */
    public function setPrixUnit($prixUnit)
    {
        $this->prixUnit = $prixUnit;

        return $this;
    }

    /**
     * Get prixUnit
     *
     * @return integer 
     */
    public function getPrixUnit()
    {
        return $this->prixUnit;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set produit
     *
     * @param \GO\ShopBundle\Entity\Produit $produit
     * @return CreanceProduit
     */
    public function setProduit(\GO\ShopBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \GO\ShopBundle\Entity\Produit 
     */
    public function getProduit()
    {
        return $this->produit;
    }
    
   

    /**
     * Add remboursements
     *
     * @param \GO\ShopBundle\Entity\RembCreanceProduit $remboursements
     * @return CreanceProduit
     */
    public function addRemboursement(\GO\ShopBundle\Entity\RembCreanceProduit $remboursements)
    {
        $this->remboursements[] = $remboursements;

        return $this;
    }

    /**
     * Remove remboursements
     *
     * @param \GO\ShopBundle\Entity\RembCreanceProduit $remboursements
     */
    public function removeRemboursement(\GO\ShopBundle\Entity\RembCreanceProduit $remboursements)
    {
        $this->remboursements->removeElement($remboursements);
    }

    /**
     * Get remboursements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRemboursements()
    {
        return $this->remboursements;
    }
   
    //===================FONCTIONS DIVERSES ============
    // renvoie le total de lacreance
    public function getTotal()
    {
        return  $this->quantite*$this->prixUnit;
    }
    //====================== renvoi le total de la somme déjà remboursé sur la créance
    public function getTotalRembourse()
    {
        $total=0;
        foreach($this->remboursements as $remb)
        {
            $total=$total+$remb->getMontant();
        }
        return (int) $total;
    }
    //====================== renvoi le total de la somme restant à rembourser sur la créance
    public function getTotalRestant()
    {
        $restant=$this->getTotal()-$this->getTotalRembourse();
        return ($restant<0) ? 0: (int)$restant;
    }
}
