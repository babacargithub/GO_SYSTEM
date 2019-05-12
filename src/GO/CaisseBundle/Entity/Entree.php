<?php

namespace GO\CaisseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entree
 *
 * @ORM\Table(name="entree_caisse")
 * @ORM\Entity(repositoryClass="GO\CaisseBundle\Repository\EntreeRepository")
 */
class Entree extends AbstractEntree
{
    

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255, nullable=true)
     */
    private $auteur;



    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Entree
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
}
