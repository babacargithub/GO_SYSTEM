<?php

namespace  GO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RembCreance
 *
 * @ORM\Table(name="remb_creance_produit")
 * @ORM\Entity(repositoryClass="GO\ShopBundle\Entity\RembCreanceProduitRepository")
 */
//==============Entité représentant les remboursements des créances 
class RembCreanceProduit extends RembCreance
{
    /**
     * @ORM\ManyToOne(targetEntity="GO\ShopBundle\Entity\CreanceProduit", inversedBy="remboursements")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="creance", referencedColumnName="id", nullable=false)})
     */
    private $creance;

    public function setCreance(\GO\ShopBundle\Entity\CreanceProduit $creance)
    {
        $this->creance = $creance;

        return $this;
    }

    /**
     * Get creance
     *
     * @return \GO\ShopBundle\Entity\Creance 
     */
    public function getCreance()
    {
        return $this->creance;
    }
}
