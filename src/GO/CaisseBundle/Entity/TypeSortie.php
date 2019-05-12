<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeSortie
 *
 * @ORM\Table(name="type_sortie")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\TypeSortieRepository")
 */
class TypeSortie extends AbstractTypeOperation
{
   

    /**
     * @var bool
     *
     * @ORM\Column(name="charge", type="boolean", nullable=true)
     */
    private $charge;


    

    /**
     * Set charge
     *
     * @param boolean $charge
     *
     * @return TypeSortie
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return bool
     */
    public function getCharge()
    {
        return $this->charge;
    }
    
}

