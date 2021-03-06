<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="marque")
 * @ORM\Entity
 */
class Marque
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_marque", type="string", length=255, nullable=true)
     */
    private $nomMarque;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_marque", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMarque;



    /**
     * Set nomMarque
     *
     * @param string $nomMarque
     * @return Marque
     */
    public function setNomMarque($nomMarque)
    {
        $this->nomMarque = $nomMarque;

        return $this;
    }

    /**
     * Get nomMarque
     *
     * @return string 
     */
    public function getNomMarque()
    {
        return $this->nomMarque;
    }

    /**
     * Get idMarque
     *
     * @return integer 
     */
    public function getIdMarque()
    {
        return $this->idMarque;
    }
}
