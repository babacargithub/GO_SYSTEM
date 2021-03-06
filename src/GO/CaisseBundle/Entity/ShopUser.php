<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserShop
 *
 * @ORM\Table(name="caisse_pro_shop_user")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\ShopUserRepository")
 */
class ShopUser
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
     * @var \GO\CaisseBundle\Entity\Shop
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Shop")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shop", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $shop;
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
     * @var boolean
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled=false;
    /**
     * @var datetime
     *
     * @ORM\Column(name="disabled_at", type="datetime",nullable=true)
     */
    private $disabledAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked=false;
    /**
     * @var datetime
     *
     * @ORM\Column(name="locked_at", type="datetime",nullable=true)
     */
    private $lockedAt;
    /**
     * @var datetime
     *
     * @ORM\Column(name="locked_until", type="datetime", nullable=true)
     */
    private $lockedUntil;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime")
     */
    private $lastLogin;
    public function __construct() {
        $this->lastLogin = new \DateTime();
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
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return ShopUser
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set disabledAt
     *
     * @param \DateTime $disabledAt
     *
     * @return ShopUser
     */
    public function setDisabledAt($disabledAt)
    {
        $this->disabledAt = $disabledAt;

        return $this;
    }

    /**
     * Get disabledAt
     *
     * @return \DateTime
     */
    public function getDisabledAt()
    {
        return $this->disabledAt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return ShopUser
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set lockedAt
     *
     * @param \DateTime $lockedAt
     *
     * @return ShopUser
     */
    public function setLockedAt($lockedAt)
    {
        $this->lockedAt = $lockedAt;

        return $this;
    }

    /**
     * Get lockedAt
     *
     * @return \DateTime
     */
    public function getLockedAt()
    {
        return $this->lockedAt;
    }

    /**
     * Set lockedUntil
     *
     * @param \DateTime $lockedUntil
     *
     * @return ShopUser
     */
    public function setLockedUntil($lockedUntil)
    {
        $this->lockedUntil = $lockedUntil;

        return $this;
    }

    /**
     * Get lockedUntil
     *
     * @return \DateTime
     */
    public function getLockedUntil()
    {
        return $this->lockedUntil;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return ShopUser
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    
    //======================Issers=======
    public function isLocked()
    {
        return $this->getLocked();
    }
    public function isDisabled()
    {
        return $this->getDisabled();
    }

    /**
     * Set shop
     *
     * @param \GO\CaisseBundle\Entity\Shop $shop
     *
     * @return ShopUser
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

    /**
     * Set user
     *
     * @param \GO\UserBundle\Entity\User $user
     *
     * @return ShopUser
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
}
