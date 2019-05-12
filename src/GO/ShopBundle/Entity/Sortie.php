<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sortie
 *
 * @ORM\Table(name="sortie")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\SortieRepository")
 */
class Sortie
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
     * @ORM\Column(name="justif", type="text")
     */
    private $justif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;
    /**
     * @var \GO\ShopBundle\Entity\Charge
     *
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Charge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poste_depense", referencedColumnName="id",onDelete="NO ACTION", nullable=false)
     * })
     */
    private $charge;

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
     * @return Sortie
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
     * Set justif
     *
     * @param string $justif
     * @return Sortie
     */
    public function setJustif($justif)
    {
        $this->justif = $justif;

        return $this;
    }

    /**
     * Get justif
     *
     * @return string 
     */
    public function getJustif()
    {
        return $this->justif;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Sortie
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
     * Set shop
     *
     * @param \GO\ShopBundle\Entity\Shop $shop
     * @return Sortie
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
     * Set user
     *
     * @param \GO\UserBundle\Entity\User $user
     * @return Sortie
     */
    public function setUser(\GO\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GO\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set charge
     *
     * @param \GO\ShopBundle\Entity\Charge $charge
     *
     * @return Sortie
     */
    public function setCharge(\GO\ShopBundle\Entity\Charge $charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return \GO\ShopBundle\Entity\Charge
     */
    public function getCharge()
    {
        return $this->charge;
    }
}
