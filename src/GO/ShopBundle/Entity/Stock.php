<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
  * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\StockRepository")
 * @ORM\HasLifecycleCallbacks()

 */
class Stock
{
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
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;
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
        $this->lastUpdate= new \DateTime();
    }

    /**
     * Set produit
     *
     * @param integer $produit
     * @return Stock
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return integer 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Stock
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
     * Set posi
     *
     * @param integer $posi
     * @return Stock
     */
    public function setPosi($posi)
    {
        $this->posi = $posi;

        return $this;
    }

    /**
     * Get posi
     *
     * @return integer 
     */
    public function getPosi()
    {
        return $this->posi;
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
     * @ORM\PreUpdate
     */
    public function updateLastUpdate()
    {
        $this->lastUpdate=new \DateTime();
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Stock
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
     * @return Stock
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
   //=====================des functions de test
   public function isVide()
   {
       if($this->quantite>0)
       {
           return false;
       }else
           return true;
   }
   public function isDispo($quantite)
   {
       if($this->quantite>=$quantite)
       {
           return true;
       }else
           return false;
   }
   //==========================FONCTIONS DIVERSES ====================
   public function augmenter($quantite)
   {
       if(!is_numeric($quantite) || !is_int($quantite))
       {
           throw new \RuntimeException("La quantité doit etre un nombre");
       }else
       {
           $new_quantite= $this->quantite+$quantite;
           $this->setQuantite($new_quantite);
           return $this;
       }
   }
   public function diminuer($quantite)
   {
       if(!is_numeric($quantite) || !is_int($quantite))
       {
           throw new \RuntimeException("La quantité doit etre un nombre");
       }else
       {
           
           $new_quantite= $this->quantite-$quantite;
           
        if($new_quantite>0)
        {
        $this->setQuantite($new_quantite);
        }else
        {
            $this->setQuantite(0);
        }
           
           return $this;
       }
   }
}
