<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dette
 *
 * @ORM\Table(name="dette_liquide")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\DetteLiquideRepository")
 */
class DetteLiquide extends Dette
{
     /**
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\Creancier", inversedBy="creances")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="creancier", referencedColumnName="id", nullable=false)})
     */
    private $creancier;

    /**
     * Set creancier
     *
     * @param \GO\ShopBundle\Entity\Creancier $creancier
     * @return DetteLiquide
     */
    public function setCreancier(\GO\ShopBundle\Entity\Creancier $creancier)
    {
        $this->creancier = $creancier;

        return $this;
    }

    /**
     * Get creancier
     *
     * @return \GO\ShopBundle\Entity\Creancier 
     */
    public function getCreancier()
    {
        return $this->creancier;
    }
}
