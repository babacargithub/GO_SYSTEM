<?php


namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Capital
 *
 * @ORM\Table("capital_shop")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\CapitalRepository")
 */
class Capital
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
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="descrip", type="string", length=255,nullable=true)
     */
    private $descrip;
    /**
     * @var string
     *
     * @ORM\Column(name="apports", type="text",nullable=true)
     */
    private $apports;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;
      /**
     * @var \GO\ShopBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shop", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $shop;

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
     * Set montant
     *
     * @param integer $montant
     * @return Capital
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set descrip
     *
     * @param string $descrip
     * @return Capital
     */
    public function setDescrip($descrip)
    {
        $this->descrip = $descrip;

        return $this;
    }

    /**
     * Get descrip
     *
     * @return string 
     */
    public function getDescrip()
    {
        return $this->descrip;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Capital
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
     * @return Capital
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

    /**
     * Set apports
     *
     * @param string $apports
     *
     * @return Capital
     */
    public function setApports($apports)
    {
        $this->apports = $apports;

        return $this;
    }

    /**
     * Get apports
     *
     * @return string
     */
    public function getApports()
    {
        return $this->apports;
    }
}
