<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractCaisse
 *
 * @ORM\MappedSuperclass()
  */
abstract class AbstractCaisse
{
    const SODLE_DEBUT_JOUENEE=1;
    const SODLE_FIN_JOUENEE=2;
    const SODLE_DEBUT_JOUENEE_PRECEDENT=11;
    const SODLE_FIN_JOUENEE_PRECEDENT=22;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="solde", type="integer")
     */
    private $solde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastOp", type="datetime")
     */
    private $lastOp;

   /**
     * @var \GO\ShopBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Shop")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shop", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $shop;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return AbstractCaisse
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set solde
     *
     * @param integer $solde
     *
     * @return AbstractCaisse
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get solde
     *
     * @return int
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set lastOp
     *
     * @param \DateTime $lastOp
     *
     * @return AbstractCaisse
     */
    public function setLastOp($lastOp)
    {
        $this->lastOp = $lastOp;

        return $this;
    }

    /**
     * Get lastOp
     *
     * @return \DateTime
     */
    public function getLastOp()
    {
        return $this->lastOp;
    }
     public function __toString() {
        return $this->getLibelle();
    }
    
    //=================fonctions diverses=================
    public function augmenterSolde($montant)
    {
        $this->solde= $this->solde+intval($montant);
    }
    public function diminuerSolde($montant)
    {
        $this->solde= $this->solde-intval($montant);
    }

    /**
     * Set shop
     *
     * @param \GO\CaisseBundle\Entity\Shop $shop
     *
     * @return AbstractCaisse
     */
    public function setShop(\GO\CaisseBundle\Entity\Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return \GO\CaisseBundle\Entity\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }
}
