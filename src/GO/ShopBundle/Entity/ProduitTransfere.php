<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitTransfere
 *
 * @ORM\Table(name="produit_transfere")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\ProduitTransfereRepository")
 */
class ProduitTransfere
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
     * @var \GO\ShopBundle\Entity\TransfertProduit
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\TransfertProduit", inversedBy="produitTransferes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transfert_produit", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $transfertProduit;

    /**
     * @var \GO\ShopBundle\Entity\Produit
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="id",onDelete="CASCADE",nullable=false)
     * })
     */
    private $produit;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;


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
     * Set quantite
     *
     * @param integer $quantite
     * @return ProduitTransfere
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
     * Set transfertProduit
     *
     * @param \GO\ShopBundle\Entity\TransfertProduit  $transfertProduit
     * @return ProduitTransfere
     */
    public function setTransfertProduit(\GO\ShopBundle\Entity\TransfertProduit  $transfertProduit)
    {
        $this->transfertProduit = $transfertProduit;

        return $this;
    }

    /**
     * Get transfertProduit
     *
     * @return \GO\ShopBundle\Entity\TransfertProduit  
     */
    public function getTransfertProduit()
    {
        return $this->transfertProduit;
    }

    /**
     * Set produit
     *
     * @param \GO\ShopBundle\Entity\Produit $produit
     * @return ProduitTransfere
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
}
