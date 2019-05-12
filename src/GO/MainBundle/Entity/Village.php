<?php

namespace  GO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Village
 *
 * @ORM\Table(name="village")
 * @ORM\Entity(repositoryClass="GO\MainBundle\Entity\VillageRepository")
 */
class Village
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=10, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nom
     *
     * @param string $nom
     * @return Village
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
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
    public function __toString() {
        return $this->nom;
    }
}
