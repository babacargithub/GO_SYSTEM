<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GO\CaisseBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass() */
class BaseClassCaisse {
       
    /**
     * @var \GO\CaisseBundle\Entity\Caisse
     *
     * @ORM\ManyToOne(targetEntity="GO\CaisseBundle\Entity\Caisse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caisse", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     * })
     */
    private $caisse;

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

    /**
     * Set caisse
     *
     * @param \GO\CaisseBundle\Entity\Caisse $caisse
     *
     * @return BaseClassCaisse
     */
    public function setCaisse(\GO\CaisseBundle\Entity\Caisse $caisse)
    {
        $this->caisse = $caisse;

        return $this;
    }

    /**
     * Get caisse
     *
     * @return \GO\CaisseBundle\Entity\Caisse
     */
    public function getCaisse()
    {
        return $this->caisse;
    }
}
