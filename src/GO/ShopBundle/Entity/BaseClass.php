<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/** @ORM\MappedSuperclass() */
class BaseClass {
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
     * @var \GO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="GO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    /**
     * Set shop
     *
     * @param \GO\ShopBundle\Entity\Shop $shop
     * @return BaseClass
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
     * @return BaseClass
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
