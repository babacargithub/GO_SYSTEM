<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitInventaire
 *
 * @ORM\Table(name="produit_inventaire")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ProduitInventaireRepository")
 */
class ProduitInventaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
     /**
     * @var \GO\ShopBundle\Entity\Achat
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Achat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_bar", referencedColumnName="id",onDelete="CASCADE",nullable=true)
     * })
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
     * @var \GO\ShopBundle\Entity\Inventaire
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Inventaire", inversedBy="produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventaire", referencedColumnName="id",onDelete="CASCADE",nullable=false)
     * })
     */
    private $inventaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_reel", type="integer", nullable=false)
     */
    private $stockReel;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_virtuel", type="integer", nullable=false)
     */
    private $stockVirtuel;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_achat", type="integer",nullable=false)
     */
    private $prixAchat;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_vente", type="integer",nullable=true)
     */
    private $prixVente;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite_perdu", type="integer",nullable=true)
     */
    private $quantitePerdu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entree", type="datetime",nullable=true)
     */
    private $dateEntree;


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
     * Set stockReel
     *
     * @param integer $stockReel
     * @return ProduitInventaire
     */
    public function setStockReel($stockReel)
    {
        $this->stockReel = $stockReel;

        return $this;
    }

    /**
     * Get stockReel
     *
     * @return integer 
     */
    public function getStockReel()
    {
        return $this->stockReel;
    }

    /**
     * Set stockVirtuel
     *
     * @param integer $stockVirtuel
     * @return ProduitInventaire
     */
    public function setStockVirtuel($stockVirtuel)
    {
        $this->stockVirtuel = $stockVirtuel;

        return $this;
    }

    /**
     * Get stockVirtuel
     *
     * @return integer 
     */
    public function getStockVirtuel()
    {
        return $this->stockVirtuel;
    }

    /**
     * Set prixAchat
     *
     * @param integer $prixAchat
     * @return ProduitInventaire
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    /**
     * Get prixAchat
     *
     * @return integer 
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * Set prixVente
     *
     * @param integer $prixVente
     * @return ProduitInventaire
     */
    public function setPrixVente($prixVente=null)
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
     * Set quantitePerdu
     *
     * @param integer $quantitePerdu
     * @return ProduitInventaire
     */
    public function setQuantitePerdu($quantitePerdu=null)
    {
        $this->quantitePerdu = $quantitePerdu;

        return $this;
    }

    /**
     * Get quantitePerdu
     *
     * @return integer 
     */
    public function getQuantitePerdu()
    {
        return $this->quantitePerdu;
    }

    /**
     * Set dateEntree
     *
     * @param \DateTime $dateEntree
     * @return ProduitInventaire
     */
    public function setDateEntree($dateEntree=null)
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    /**
     * Get dateEntree
     *
     * @return \DateTime 
     */
    public function getDateEntree()
    {
        return $this->dateEntree;
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
     * Set inventaire
     *
     * @param \GO\ShopBundle\Entity\Inventaire $inventaire
     * @return ProduitInventaire
     */
    public function setInventaire(\GO\ShopBundle\Entity\Inventaire $inventaire)
    {
        $this->inventaire = $inventaire;

        return $this;
    }

    /**
     * Set produit
     *
     * @param \GO\ShopBundle\Entity\Produit $produit
     * @return ProduitInventaire
     */
    public function setProduit(\GO\ShopBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get inventaire
     *
     * @return \GO\ShopBundle\Entity\Inventaire 
     */
    public function getInventaire()
    {
        return $this->inventaire;
    }

    /**
     * Set codeBar
     *
     * @param \GO\ShopBundle\Entity\Achat $codeBar
     *
     * @return ProduitInventaire
     */
    public function setCodeBar($codeBar = null)
    {
        $this->codeBar = $codeBar;

        return $this;
    }

    /**
     * Get codeBar
     *
     * @return \GO\ShopBundle\Entity\Achat
     */
    public function getCodeBar()
    {
        return $this->codeBar;
    }
}
