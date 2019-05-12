<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caisse
 *
 * @ORM\Table(name="caisse")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CaisseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Caisse
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
     * @var integer
     *
     * @ORM\Column(name="solde", type="integer")
     */
    private $solde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;
    /**
     * @var \GO\ShopBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Shop", inversedBy="ventes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shop", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $shop;
    /**
     * @ORM\PreUpdate()
     */
    public function updateLastUpdate()
    {
        $this->lastUpdate=new \DateTime();
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
     * Set solde
     *
     * @param integer $solde
     * @return Caisse
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get solde
     *
     * @return integer 
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Caisse
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

    /**
     * Set shop
     *
     * @param \GO\ShopBundle\Entity\Shop $shop
     * @return Caisse
     */
    public function setShop(\GO\ShopBundle\Entity\Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return \GO\ShopBundle\Entity\Shop 
     */
    public function getShop()
    {
        return $this->shop;
    }
    
    //================================= EXTRA FUNCTIONS
    public function ajouter($montant)
    {
        $mont= $this->solde+$montant;
        $this->setSolde($mont);
        $this->setLastUpdate(new \DateTime());
    }
    public function diminuer($montant)
    {
        $mont= $this->solde-$montant;
        $this->setSolde($mont);
        $this->setLastUpdate(new \DateTime());
    }
}
