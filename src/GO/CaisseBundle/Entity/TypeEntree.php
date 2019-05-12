<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEntree
 *
 * @ORM\Table(name="type_entree")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\TypeEntreeRepository")
 */
class TypeEntree extends AbstractTypeOperation
{
   

    /**
     * @var bool
     *
     * @ORM\Column(name="produit", type="boolean", nullable=true)
     */
    private $produit;



    /**
     * Set produit
     *
     * @param boolean $produit
     *
     * @return TypeEntree
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return bool
     */
    public function getProduit()
    {
        return $this->produit;
    }
}

