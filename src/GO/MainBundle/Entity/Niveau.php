<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity
 */
class Niveau
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_niveau", type="string", length=255, nullable=true)
     */
    private $nomNiveau;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nomNiveau
     *
     * @param string $nomNiveau
     * @return Niveau
     */
    public function setNomNiveau($nomNiveau)
    {
        $this->nomNiveau = $nomNiveau;

        return $this;
    }

    /**
     * Get nomNiveau
     *
     * @return string 
     */
    public function getNomNiveau()
    {
        return $this->nomNiveau;
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
}
