<?php

namespace GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserShop
 *
 * @ORM\Table(name="user_shop")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\UserShopRepository")
 */
class UserShop extends BaseClass
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
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bloque", type="boolean")
     */
    private $bloque;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogin", type="datetime")
     */
    private $lastLogin;


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
     * Set actif
     *
     * @param boolean $actif
     * @return UserShop
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set bloque
     *
     * @param boolean $bloque
     * @return UserShop
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return boolean 
     */
    public function getBloque()
    {
        return $this->bloque;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return UserShop
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
}
