<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

/**
 * Achat
 *
 * @ORM\Table(name="achat", indexes={@ORM\Index(name="fk_id_produit_achete", columns={"produit"})})
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\AchatRepository")
 */
class Achat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="code_bar", type="string", nullable=true)
     */
    
    private $codeBar;   
    

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
     * @ORM\Column(name="prix_unit", type="integer", nullable=false)
     */
    private $prixUnit;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_vente", type="integer", nullable=true)
     */
    private $prixVente;

     /**
     * @var \GO\ShopBundle\Entity\FactureAchat
     *
     * @ORM\ManyToOne(targetEntity="\GO\ShopBundle\Entity\FactureAchat", inversedBy="achats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facture", referencedColumnName="id",onDelete="CASCADE",nullable=false)
     * })
      * @MaxDepth(2)
     */
    private $facture;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean", nullable=false)
     */
    private $paye;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="quantite_restant", type="integer", nullable=true)
     */
    private $quantiteRestant;
   
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=true)
     */
    private $lastUpdate;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->date=new \DateTime();
        $this->quantiteRestant= $this->quantite;
    }

    


    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Achat
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
     * @return Achat
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
     * Set prixVente
     *
     * @param integer $prixVente
     * @return Achat
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return integer 
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set paye
     *
     * @param boolean $paye
     * @return Achat
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;

        return $this;
    }

    /**
     * Get paye
     *
     * @return boolean 
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Achat
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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
     * @return Achat
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
     * Set facture
     *
     * @param \GO\ShopBundle\Entity\FactureAchat $facture
     * @return Achat
     */
    public function setFacture(\GO\ShopBundle\Entity\FactureAchat $facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \GO\ShopBundle\Entity\FactureAchat 
     */
    public function getFacture()
    {
        return $this->facture;
    }

    
    

    /**
     * Set codeBar
     *
     * @param integer $codeBar
     * @return Achat
     */
    public function setCodeBar($codeBar)
    {
        $this->codeBar = $codeBar;

        return $this;
    }

    /**
     * Get codeBar
     *
     * @return integer 
     */
    public function getCodeBar()
    {
        return $this->codeBar;
    }

    /**
     * Set quantiteRestant
     *
     * @param integer $quantiteRestant
     *
     * @return Achat
     */
    public function setQuantiteRestant($quantiteRestant)
    {
        $this->quantiteRestant = $quantiteRestant;

        return $this;
    }

    /**
     * Get quantiteRestant
     *
     * @return integer
     */
    public function getQuantiteRestant()
    {
        return $this->quantiteRestant;
    }
    public function isStockVide()
   {
       if($this->quantiteRestant>0)
       {
           return false;
       }else
           return true;
   }
   public function isStockDispo($quantite)
   {
       if($this->quantiteRestant>=$quantite)
       {
           return true;
       }else
           return false;
   }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return Achat
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
    
    //=================functions diverses ================
     public function diminuer($quantite)
     {
         $this->quantiteRestant=$this->getQuantiteRestant()-$quantite;
         return $this;
     }
    //=================functions diverses ================
     public function augmenter($quantite)
     {
         $this->quantiteRestant=$this->getQuantiteRestant()+$quantite;
         return $this;
     }


   public function __toString() {
        return !is_null($this->codeBar)?$this->codeBar: null;
    }
}
